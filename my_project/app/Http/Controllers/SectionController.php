<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // Список всех разделов
    public function index()
    {
        $sections = Section::with(['tasks', 'tasks.userProgress' => function($q) {
            $q->where('user_id', auth()->id());
        }])->get();

        return view('sections.index', compact('sections'));
    }

    public function tasksJson($id)
    {
        $tasks = Section::findOrFail($id)->tasks()->get(['id', 'title', 'description', 'difficulty', 'points']);
        return response()->json($tasks);
    }


    // Страница конкретного раздела
    public function show(Section $section)
    {
        // Можно передать задачи раздела, темы, и т.д.
        $tasks = $section->tasks()->get(); // если есть связь tasks() в модели Section
        return view('sections.show', compact('section', 'tasks'));
    }
}
