<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Получаем все достижения с информацией о том, какие из них получены пользователем
        $achievements = Achievement::with(['users' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->orderBy('xp_reward', 'desc')->get();

        // Статистика пользователя
        $stats = [
            'total_achievements' => Achievement::count(),
            'unlocked_achievements' => $user->achievements()->count(),
            'completion_percentage' => Achievement::count() > 0 ?
                round(($user->achievements()->count() / Achievement::count()) * 100, 1) : 0,
        ];

        return view('achievements.index', compact('achievements', 'user', 'stats'));
    }
}
