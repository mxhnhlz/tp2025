<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\UserTaskProgress;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Статистика пользователя
        $completedTasks = UserTaskProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at');

        $stats = [
            'total_tasks_completed' => $completedTasks->count(),
            'average_accuracy' => $completedTasks->avg('accuracy') ?? 0,
            'total_xp' => $user->xp,
            'level' => $user->level,
            // Формула: следующий уровень = (текущий уровень + 1)^2 * 100
            'next_level_xp' => pow($user->level + 1, 2) * 100,
            'xp_to_next_level' => max(0, pow($user->level + 1, 2) * 100 - $user->xp),
            // Текущий прогресс в процентах
            'level_progress_percentage' => $user->xp > 0 ?
                min(100, ($user->xp / pow($user->level + 1, 2) * 100)) : 0,
        ];

        // 2. Последние пройденные задания с расчетом XP
        $recentProgress = UserTaskProgress::with(['task.section'])
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($progress) {
                // Добавляем вычисленный XP
                $progress->xp_earned = $progress->task->points * ($progress->accuracy / 100);

                return $progress;
            });

        // 3. Последние достижения
        $recentAchievements = $user->achievements()
            ->orderBy('user_achievements.unlocked_at', 'desc')
            ->limit(3)
            ->get();

        // 4. Прогресс по разделам - используем правильное название отношения userTaskProgress
        $sections = Section::with(['tasks' => function ($query) use ($user) {
            $query->withCount(['userTaskProgress' => function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereNotNull('completed_at');
            }]);
        }])->get()
            ->map(function ($section) {
                // Считаем прогресс по разделу
                $totalTasks = $section->tasks->count();
                $completedTasks = $section->tasks->sum('user_task_progress_count'); // Обратите внимание на имя
                $section->progress_percentage = $totalTasks > 0 ?
                    ($completedTasks / $totalTasks) * 100 : 0;
                $section->completed_tasks = $completedTasks;
                $section->total_tasks = $totalTasks;

                return $section;
            });

        return view('auth.cabinet', compact(
            'user',
            'stats',
            'recentProgress',
            'recentAchievements',
            'sections'
        ));
    }
}
