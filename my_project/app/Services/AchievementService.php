<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserTaskProgress;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    public function checkAndUnlockAchievements(User $user)
    {
        $this->checkTaskCountAchievements($user);
        $this->checkSectionAchievements($user);
        $this->checkAccuracyAchievements($user);
        $this->checkLevelAchievements($user);
        $this->checkStreakAchievements($user);

        return $user->achievements()->count();
    }

    private function checkTaskCountAchievements(User $user)
    {
        $completedTasks = UserTaskProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();

        $achievements = Achievement::where('type', 'tasks_count')->get();

        foreach ($achievements as $achievement) {
            $conditions = json_decode($achievement->conditions, true);
            $requiredCount = $conditions['count'] ?? 0;

            if ($completedTasks >= $requiredCount) {
                $this->unlockAchievement($user, $achievement);
            }
        }
    }

    private function checkSectionAchievements(User $user)
    {
        $sections = \App\Models\Section::with('tasks')->get();

        foreach ($sections as $section) {
            $sectionTasks = $section->tasks->pluck('id');

            if ($sectionTasks->count() > 0) {
                $completedInSection = UserTaskProgress::where('user_id', $user->id)
                    ->whereIn('task_id', $sectionTasks)
                    ->whereNotNull('completed_at')
                    ->count();

                if ($completedInSection === $sectionTasks->count()) {
                    $achievement = Achievement::where('type', 'section_complete')
                        ->whereJsonContains('conditions->section_id', $section->id)
                        ->first();

                    if ($achievement) {
                        $this->unlockAchievement($user, $achievement);
                    }
                }
            }
        }
    }

    private function checkAccuracyAchievements(User $user)
    {
        // Проверяем среднюю точность по всем заданиям
        $averageAccuracy = UserTaskProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->avg('accuracy') ?? 0;

        $achievements = Achievement::where('type', 'accuracy')->get();

        foreach ($achievements as $achievement) {
            $conditions = json_decode($achievement->conditions, true);
            $requiredAccuracy = $conditions['accuracy'] ?? 0;

            if ($averageAccuracy >= $requiredAccuracy) {
                $this->unlockAchievement($user, $achievement);
            }
        }

        // Проверяем идеальное прохождение (100% точность в любом задании)
        $perfectTasks = UserTaskProgress::where('user_id', $user->id)
            ->where('accuracy', 100)
            ->count();

        if ($perfectTasks > 0) {
            $achievement = Achievement::where('slug', 'perfectionist')->first();
            if ($achievement) {
                $this->unlockAchievement($user, $achievement);
            }
        }
    }

    private function checkLevelAchievements(User $user)
    {
        $achievements = Achievement::where('type', 'level')->get();
        foreach ($achievements as $achievement) {
            $conditions = json_decode($achievement->conditions, true);
            $requiredLevel = $conditions['level'] ?? 0;

            if ($user->level >= $requiredLevel) {
                $this->unlockAchievement($user, $achievement);
            }
        }
    }

    private function checkStreakAchievements(User $user)
    {
        // Проверка ежедневных посещений (упрощенная версия)
        $loginDays = 7;
        $achievement = Achievement::where('type', 'login_streak')->first();

        if ($achievement) {
            $conditions = json_decode($achievement->conditions, true);
            $requiredStreak = $conditions['days'] ?? 0;

            if ($loginDays >= $requiredStreak) {
                $this->unlockAchievement($user, $achievement);
            }
        }
    }

    private function unlockAchievement(User $user, Achievement $achievement)
    {
        // Используем DB facade
        $exists = DB::table('user_achievements')
            ->where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->exists();

        if (! $exists) {
            DB::table('user_achievements')->insert([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
                'unlocked_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Добавляем XP за достижение
            $xpReward = $achievement->xp_reward ?? 50;
            $user->increment('xp', $xpReward);

            // Проверяем повышение уровня
            $this->checkLevelUp($user);

            // Можно добавить отправку уведомления
            // event(new \App\Events\AchievementUnlocked($user, $achievement));

            return true;
        }

        return false;
    }

    private function checkLevelUp(User $user)
    {
        $newLevel = floor(sqrt($user->xp / 100 + 1));

        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            $user->save();
        }
    }
}
