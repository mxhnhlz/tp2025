<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Task;
use DB;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    // Список вопросов (для админа)
    public function index(Request $request)
    {
        $builder = Question::with(['task', 'options', 'textAnswers']);
        if ($request->get('type')) {
            $builder->where('type', '=', $request->get('type'));
        }

        $questions = $builder
            ->orderBy($request->get('sort') ?? 'id', $request->get('direction') ?? 'asc')
            ->orderBy('order')
            ->paginate(6);

        return view('admin.questions.index', compact('questions'));
    }

    // Форма создания вопроса
    public function create()
    {
        $tasks = Task::all();
        return view('admin.questions.create', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'type' => 'required|in:single,multiple,text',
            'hint' => 'nullable|string',
            'answers' => 'required_if:type,single,multiple|array|min:1',
            'answers.*.content' => 'required_if:type,single,multiple|string',
            'answers.*.is_correct' => 'nullable',
            'correct_answer' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $question = Question::create([
                'task_id' => $validated['task_id'],
                'content' => $validated['content'],
                'type' => $validated['type'],
                'hint' => $validated['hint'] ?? null,
            ]);

            if ($validated['type'] === 'text') {
                $question->textAnswers()->create([
                    'correct_answer' => $validated['correct_answer'],
                    'is_case_sensitive' => false,
                    'is_exact_match' => true,
                ]);
            } else {
                foreach ($validated['answers'] as $index => $answer) {
                    $question->options()->create([
                        'content' => $answer['content'],
                        'is_correct' => isset($answer['is_correct']) && $answer['is_correct'] == '1',
                        'order_position' => $index,
                    ]);
                }
            }
        });

        return redirect()->route('admin.questions.index')
            ->with('success', 'Вопрос успешно создан!');
    }


    // Показ конкретного вопроса
    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $question->load(['options', 'textAnswers']);
        $tasks = Task::orderBy('title')->get();
        return view('admin.questions.edit', compact('question', 'tasks'));
    }

    public function update(Request $request, Question $question)
    {

        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'type' => 'required|in:single,multiple,text',
            'hint' => 'nullable|string',
            'answers' => 'required_if:type,single,multiple|array|min:2',
            'answers.*.content' => 'required_if:type,single,multiple|string',
            'answers.*.is_correct' => 'nullable',
            'correct_answer' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $question) {
            $question->update([
                'task_id' => $validated['task_id'],
                'content' => $validated['content'],
                'type' => $validated['type'],
                'hint' => $validated['hint'] ?? null,
            ]);

            // Удаляем старые связи
            $question->options()->delete();
            $question->textAnswers()->delete();

            if ($validated['type'] === 'text') {
                $question->textAnswers()->create([
                    'correct_answer' => $validated['correct_answer'],
                    'is_case_sensitive' => false,
                    'is_exact_match' => true,
                ]);
            } else {
                foreach ($validated['answers'] as $index => $answer) {
                    $question->options()->create([
                        'content' => $answer['content'],
                        'is_correct' => isset($answer['is_correct']) && $answer['is_correct'] == '1',
                        'order_position' => $index,
                    ]);
                }
            }
        });

        return redirect()->route('admin.questions.index')
            ->with('success', 'Вопрос успешно обновлен!');
    }

    // Удаление вопроса
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Вопрос удалён!');
    }

}
