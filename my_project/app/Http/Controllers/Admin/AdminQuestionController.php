<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminQuestionController extends Controller
{
    public function index(Request $request)
    {
        $builder = Question::with(['task', 'options', 'textAnswers']);

        if ($request->filled('type')) {
            $builder->where('type', $request->type);
        }

        $questions = $builder
            ->orderBy('order')
            ->paginate(10);

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $tasks = Task::orderBy('title')->get();

        return view('admin.questions.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $rules = [
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'type' => 'required|in:single,multiple,text',
            'hint' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ];

        if (in_array($request->type, ['single', 'multiple'])) {
            $rules['answers.*.content'] = 'required|string';
            $rules['answers.*.is_correct'] = 'nullable|boolean';

            // ДОБАВЛЯЕМ: Проверка для single вопроса
            if ($request->type === 'single') {
                $rules['answers'] = [
                    'required',
                    'array',
                    'min:2',
                    function ($attribute, $value, $fail) {
                        $correctCount = 0;
                        foreach ($value as $answer) {
                            if (isset($answer['is_correct']) && $answer['is_correct'] == '1') {
                                $correctCount++;
                            }
                        }

                        if ($correctCount !== 1) {
                            $fail('Для вопроса с одним правильным ответом должен быть выбран ровно один правильный вариант');
                        }
                    }
                ];
            } else {
                $rules['answers'] = 'required|array|min:2';
            }
        }

        if ($request->type === 'text') {
            $rules['correct_answer'] = 'required|string';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated) {
            $question = Question::create([
                'task_id' => $validated['task_id'],
                'content' => $validated['content'],
                'type' => $validated['type'],
                'hint' => $validated['hint'] ?? null,
                'order' => $validated['order'],
            ]);

            if ($validated['type'] === 'text') {
                $question->textAnswers()->create([
                    'correct_answer' => $validated['correct_answer'],
                ]);
            } else {
                foreach ($validated['answers'] as $index => $answer) {
                    $isCorrect = isset($answer['is_correct']) && $answer['is_correct'] == '1';

                    $question->options()->create([
                        'content' => $answer['content'],
                        'is_correct' => $isCorrect,
                        'order_position' => $index,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Вопрос успешно создан');
    }

    public function edit(Question $question)
    {
        $question->load(['options', 'textAnswers']);
        $tasks = Task::orderBy('title')->get();

        return view('admin.questions.edit', compact('question', 'tasks'));
    }

    public function update(Request $request, Question $question)
    {
        $rules = [
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'type' => 'required|in:single,multiple,text',
            'hint' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ];

        if (in_array($request->type, ['single', 'multiple'])) {
            $rules['answers.*.content'] = 'required|string';
            $rules['answers.*.is_correct'] = 'nullable|boolean';

            // ДОБАВЛЯЕМ: Проверка для single вопроса
            if ($request->type === 'single') {
                $rules['answers'] = [
                    'required',
                    'array',
                    'min:2',
                    function ($attribute, $value, $fail) {
                        $correctCount = 0;
                        foreach ($value as $answer) {
                            if (isset($answer['is_correct']) && $answer['is_correct'] == '1') {
                                $correctCount++;
                            }
                        }

                        if ($correctCount !== 1) {
                            $fail('Для вопроса с одним правильным ответом должен быть выбран ровно один правильный вариант');
                        }
                    }
                ];
            } else {
                $rules['answers'] = 'required|array|min:2';
            }
        }

        if ($request->type === 'text') {
            $rules['correct_answer'] = 'required|string';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $question) {
            $question->update([
                'task_id' => $validated['task_id'],
                'content' => $validated['content'],
                'type' => $validated['type'],
                'hint' => $validated['hint'] ?? null,
                'order' => $validated['order'],
            ]);

            // Удаляем старые ответы
            $question->options()->delete();
            $question->textAnswers()->delete();

            if ($validated['type'] === 'text') {
                $question->textAnswers()->create([
                    'correct_answer' => $validated['correct_answer'],
                ]);
            } else {
                foreach ($validated['answers'] as $index => $answer) {
                    $isCorrect = isset($answer['is_correct']) && $answer['is_correct'] == '1';

                    $question->options()->create([
                        'content' => $answer['content'],
                        'is_correct' => $isCorrect,
                        'order_position' => $index,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Вопрос успешно обновлён');
    }

    public function show(Question $question)
    {
        $question->load(['task', 'options', 'textAnswers']);

        return view('admin.questions.show', compact('question'));
    }
}
