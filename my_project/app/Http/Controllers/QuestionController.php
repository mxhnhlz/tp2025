<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Task;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Список вопросов (для админа)
    public function index()
    {
        $questions = Question::with('task')->orderBy('task_id')->orderBy('order')->get();
        return view('questions.index', compact('questions'));
    }
    // Форма создания вопроса
    public function create()
    {
        $tasks = Task::all();
        return view('questions.create', compact('tasks'));
    }
    // Сохранение нового вопроса
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'type' => 'required|in:single_choice,multiple_choice,text',
            'hint' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        Question::create($validated);

        return redirect()->route('questions.index')->with('success', 'Вопрос добавлен!');
    }

    // Показ конкретного вопроса
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // Форма редактирования вопроса
    public function edit(Question $question)
    {
        $tasks = Task::all();
        return view('questions.edit', compact('question', 'tasks'));
    }
    // Обновление вопроса
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
            'type' => 'required|in:single_choice,multiple_choice,text',
            'hint' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ]);

        $question->update($validated);

        return redirect()->route('questions.index')->with('success', 'Вопрос обновлён!');
    }
    // Удаление вопроса
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Вопрос удалён!');
    }

}
