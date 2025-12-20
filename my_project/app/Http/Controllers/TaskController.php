<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Task;
use Illuminate\Http\Request;

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
            $validated['points'] = match($validated['difficulty']) {
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
        return view('tasks.show', compact('task'));
    }

    // Форма редактирования задания
    public function edit(Task $task)
    {
        $sections = Section::all();
        return view('tasks.edit', compact('task', 'sections'));
    }

    // Обновление задания
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:tasks,slug,' . $task->id,
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'points' => 'nullable|integer|min:1',
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['points'])) {
            $validated['points'] = match($validated['difficulty']) {
                'easy' => 5,
                'medium' => 10,
                'hard' => 20,
                default => $task->points
            };
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Задание обновлено!');
    }

    // Удаление задания
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Задание удалено!');
    }
}
