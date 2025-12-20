<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Theory;
use Illuminate\Http\Request;

class TheoryController extends Controller
{
    // Список всех теорий (для админа)
    public function index()
    {
        $theories = Theory::with('task')->get();
        return view('theories.index', compact('theories'));
    }
    // Форма создания теории
    public function create()
    {
        $tasks = Task::all();
        return view('theories.create', compact('tasks'));
    }

    // Сохранение новой теории
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ]);

        Theory::create($validated);

        return redirect()->route('theories.index')->with('success', 'Теория добавлена!');
    }
    // Показ конкретной теории
    public function show(Theory $theory)
    {
        return view('theories.show', compact('theory'));
    }

    // Форма редактирования теории
    public function edit(Theory $theory)
    {
        $tasks = Task::all();
        return view('theories.edit', compact('theory', 'tasks'));
    }
    // Обновление теории
    public function update(Request $request, Theory $theory)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ]);

        $theory->update($validated);

        return redirect()->route('theories.index')->with('success', 'Теория обновлена!');
    }
    // Удаление теории
    public function destroy(Theory $theory)
    {
        $theory->delete();
        return redirect()->route('theories.index')->with('success', 'Теория удалена!');
    }
}
