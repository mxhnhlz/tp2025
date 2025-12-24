<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\UserTaskProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    // Список всех разделов
    public function index()
    {
        $user = auth()->user();

        $sections = Section::with(['tasks' => function($query) use ($user) {
            $query->with(['userTaskProgress' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);
        }])->get()
            ->map(function($section) {
                // Считаем прогресс для каждого раздела
                $totalTasks = $section->tasks->count();
                $completedTasks = $section->tasks->filter(function($task) {
                    return $task->userTaskProgress && $task->userTaskProgress->isNotEmpty();
                })->count();

                $section->total_tasks = $totalTasks;
                $section->completed_tasks = $completedTasks;
                $section->progress_percentage = $totalTasks > 0 ?
                    ($completedTasks / $totalTasks) * 100 : 0;

                return $section;
            });

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
        // Получаем задачи раздела с прогрессом пользователя
        $user = Auth::user();
        $tasks = $section->tasks()->with(['userTaskProgress' => function($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->get();

        return view('sections.show', compact('section', 'tasks'));
    }
}
