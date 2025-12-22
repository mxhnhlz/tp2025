<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Task;
use App\Models\UserTaskProgress;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Показать список всех заданий
    public function index()
    {
        $sections = Section::with('tasks')->get(); // подтягиваем задания вместе с разделами

        return view('tasks', compact('sections'));
    }

    // Форма создания нового задания
    public function create()
    {
        $sections = Section::all(); // чтобы выбрать к какому разделу привязать

        return view('tasks.create', compact('sections'));
    }

    // Сохранить новое задание
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

        // Если points не указаны, можно выставить по умолчанию (например через уровень сложности)
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

    // Показать конкретное задание
    public function show(Task $task)
    {
        $task->load(['theory', 'questions.options', 'questions.textAnswers']);

        // Прогресс пользователя по этому заданию
        $progress = UserTaskProgress::firstOrCreate([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
        ]);

        return view('tasks.show', compact('task', 'progress'));
    }

    public function storeAnswer(Request $request, Task $task)
    {
        $userId = auth()->id();
        $questionId = $request->input('question_id');
        $answer = $request->input('answer');

        $question = $task->questions()->findOrFail($questionId);

        if ($question->type === 'text') {
            $question->userAnswers()->updateOrCreate(
                ['user_id' => $userId],
                ['answer' => $answer]
            );
        } else {
            // Для single/multiple
            $question->userAnswers()->where('user_id', $userId)->delete();

            foreach ((array) $answer as $optionId) {
                $question->userAnswers()->create([
                    'user_id' => $userId,
                    'option_id' => $optionId,
                ]);
            }
        }
        $achievementService = new AchievementService;
        $achievementService->checkAchievements(Auth::user());

        return response()->json(['success' => true]);

    }
}
