<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Theory;
use Illuminate\Http\Request;

class AdminTheoryController extends Controller
{
    // Список всех теорий (для админа)
    public function index()
    {
        $theories = Theory::with('task')->get();
        return view('admin.theories.index', compact('theories'));
    }
    // Форма создания теории
    public function create()
    {
        $tasks = Task::all();
        $theory = null;
        return view('admin.theories.create', compact('tasks', 'theory'));
    }

    // Сохранение новой теории
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ]);

        Theory::create($validated);

        return redirect()
            ->route('admin.theories.index')
            ->with('success', 'Теория добавлена!');
    }
    // Показ конкретной теории
    public function show(Theory $theory)
    {
        return view('admin.theories.show', compact('theory'));
    }

    // Форма редактирования теории
    public function edit(Theory $theory)
    {
        $tasks = Task::all();
        return view('admin.theories.create', compact('theory', 'tasks'));
    }
    // Обновление теории
    public function update(Request $request, Theory $theory)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string',
        ]);

        $theory->update($validated);

        return redirect()
            ->route('admin.theories.index')
            ->with('success', 'Теория обновлена!');
    }
    // Удаление теории
    public function destroy(Theory $theory)
    {
        $theory->delete();
        return redirect()
            ->route('admin.theories.index')
            ->with('success', 'Теория удалена!');
    }
}
