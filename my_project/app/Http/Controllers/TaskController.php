<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Section;
use App\Models\Task;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserTaskProgress;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $sections = Section::with('tasks')->get();

        return view('tasks', compact('sections'));
    }

    public function create()
    {
        $sections = Section::all();

        return view('tasks.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:tasks,slug',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'points' => 'nullable|integer|min:1',
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['points'])) {
            $validated['points'] = match ($validated['difficulty']) {
                'easy' => 5,
                'medium' => 10,
                'hard' => 20,
                default => 10
            };
        }

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Задание создано!');
    }

    public function show(Task $task)
    {
        $task->load(['theory', 'questions.options', 'questions.textAnswers']);

        $progress = UserTaskProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
        ]);

        return view('tasks.show', compact('task', 'progress'));
    }

    public function storeAnswer(Request $request, Task $task)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
        ]);

        $userId = auth()->id();
        $questionId = $request->input('question_id');
        $question = Question::with(['options', 'textAnswers'])->findOrFail($questionId);

        // Очищаем старые ответы на этот вопрос
        UserAnswer::where('user_id', $userId)
            ->where('question_id', $questionId)
            ->delete();

        $isCorrect = false;

        // 1. Одиночный выбор
        if ($question->type === 'single') {
            $optionId = $request->input('answer');
            $selectedOption = $question->options->find($optionId);

            if ($selectedOption) {
                UserAnswer::create([
                    'user_id' => $userId,
                    'question_id' => $questionId,
                    'option_id' => $optionId,
                    'is_correct' => $selectedOption->is_correct,
                ]);
                $isCorrect = (bool) $selectedOption->is_correct;
            }
        }
        // 2. Множественный выбор
        elseif ($question->type === 'multiple') {
            $selectedOptionIds = (array) $request->input('answers', []);
            $correctOptionIds = $question->options->where('is_correct', true)->pluck('id')->toArray();

            sort($selectedOptionIds);
            sort($correctOptionIds);

            $isCorrect = ($selectedOptionIds === $correctOptionIds);

            foreach ($selectedOptionIds as $optionId) {
                UserAnswer::create([
                    'user_id' => $userId,
                    'question_id' => $questionId,
                    'option_id' => $optionId,
                    'is_correct' => in_array($optionId, $correctOptionIds),
                ]);
            }
        }
        // 3. Текстовый ответ (ИСПРАВЛЕНО)
        elseif ($question->type === 'text') {
            $userAnswerRaw = $request->input('answer', '');
            $correctAnswerModel = $question->textAnswers->first();

            if ($correctAnswerModel) {
                $userAnswer = mb_strtolower(trim($userAnswerRaw), 'UTF-8');
                $dbAnswer = mb_strtolower(trim($correctAnswerModel->correct_answer), 'UTF-8');

                if ($correctAnswerModel->is_exact_match) {
                    $isCorrect = ($userAnswer === $dbAnswer);
                } else {
                    $isCorrect = str_contains($userAnswer, $dbAnswer);
                }

                UserAnswer::create([
                    'user_id' => $userId,
                    'question_id' => $questionId,
                    'text_answer' => $userAnswerRaw,
                    'is_correct' => $isCorrect,
                ]);
            }
        }

        $this->updateTaskProgress($userId, $task);

        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
        ]);
    }

    private function updateTaskProgress($userId, Task $task)
    {
        $totalQuestions = $task->questions()->count();
        if ($totalQuestions === 0) return;

        $correctAnswersCount = UserAnswer::where('user_id', $userId)
            ->whereIn('question_id', $task->questions()->pluck('id'))
            ->where('is_correct', true)
            ->distinct('question_id')
            ->count('question_id');

        $accuracy = ($correctAnswersCount / $totalQuestions) * 100;

        $existingProgress = UserTaskProgress::where('user_id', $userId)
            ->where('task_id', $task->id)
            ->first();

        $alreadyCompleted = $existingProgress && $existingProgress->completed_at !== null;
        $oldAccuracy = $existingProgress ? $existingProgress->accuracy : 0;

        // Обновляем прогресс
        $progress = UserTaskProgress::updateOrCreate(
            ['user_id' => $userId, 'task_id' => $task->id],
            [
                'score' => $accuracy,
                'accuracy' => $accuracy,
                'completed_at' => $alreadyCompleted ? $existingProgress->completed_at : now(),
            ]
        );

        // ЛОГИКА ВЫЗОВА СЕРВИСА:
        // 1. Если это самое первое прохождение
        // 2. ИЛИ если точность стала выше (чтобы поймать 100% для Перфекциониста)
        if (!$alreadyCompleted || $accuracy > $oldAccuracy) {
            $this->addTaskExperience($userId, $task, $accuracy, $alreadyCompleted, $oldAccuracy);
        }
    }

    private function addTaskExperience($userId, Task $task, $accuracy, $alreadyCompleted = false, $oldAccuracy = 0)
    {
        $user = User::find($userId);
        if (!$user) return;

        // Начисляем разницу в XP только если текущий результат лучше предыдущего
        if ($accuracy > $oldAccuracy) {
            $newXp = (int) ($task->points * ($accuracy / 100));
            $oldXp = (int) ($task->points * ($oldAccuracy / 100));
            $xpToIncrement = $newXp - $oldXp;

            if ($xpToIncrement > 0) {
                $user->increment('xp', $xpToIncrement);
                $user->refresh();
            }
        }

        // ТЕПЕРЬ СЕРВИС ВЫЗЫВАЕТСЯ ВСЕГДА ПРИ УЛУЧШЕНИИ РЕЗУЛЬТАТА
        $achievementService = new AchievementService;
        $achievementService->checkAndUnlockAchievements($user);
    }

    public function completeTask(Request $request, Task $task)
    {
        $userId = auth()->id();
        $totalQuestions = $task->questions()->count();

        $correctAnswers = UserAnswer::where('user_id', $userId)
            ->whereIn('question_id', $task->questions()->pluck('id'))
            ->where('is_correct', true)
            ->distinct('question_id')
            ->count('question_id');

        $accuracy = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $existingProgress = UserTaskProgress::where('user_id', $userId)->where('task_id', $task->id)->first();
        $alreadyCompleted = $existingProgress && $existingProgress->completed_at !== null;

        UserTaskProgress::updateOrCreate(
            ['user_id' => $userId, 'task_id' => $task->id],
            [
                'score' => $accuracy,
                'accuracy' => $accuracy,
                'completed_at' => $alreadyCompleted ? $existingProgress->completed_at : now(),
            ]
        );

        // В методе completeTask исправьте условие в конце:
        if (!$alreadyCompleted) {
            $this->addTaskExperience($userId, $task, $accuracy);
        }

        return response()->json([
            'success' => true,
            'accuracy' => round($accuracy, 2),
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
            'xp_gained' => (int) ($task->points * ($accuracy / 100)),
        ]);
    }
}
