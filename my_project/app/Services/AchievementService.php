<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Models\Section;

class AchievementService
{
    public static function checkAndUnlockAchievements(User $user)
    {
        // Получаем все возможные достижения
        $achievements = Achievement::all();

        foreach ($achievements as $achievement) {
            if (self::checkAchievement($user, $achievement)) {
                self::unlockAchievement($user, $achievement);
            }
        }
    }

    private static function checkAchievement(User $user, Achievement $achievement): bool
    {
        // Если достижение уже получено, пропускаем
        if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
            return false;
        }

        switch ($achievement->type) {
            case 'tasks_count':
                return self::checkTasksCountAchievement($user, $achievement);

            case 'section_complete':
                return self::checkSectionCompleteAchievement($user, $achievement);

            case 'all_sections':
                return self::checkAllSectionsAchievement($user, $achievement);

            case 'daily_streak':
                return self::checkDailyStreakAchievement($user, $achievement);

            default:
                return false;
        }
    }

    private static function checkTasksCountAchievement(User $user, Achievement $achievement): bool
    {
        $conditions = $achievement->conditions;
        $requiredCount = $conditions['count'] ?? 0;

        $completedTasks = $user->userTaskProgress()->count();

        return $completedTasks >= $requiredCount;
    }

    private static function checkSectionCompleteAchievement(User $user, Achievement $achievement): bool
    {
        $conditions = $achievement->conditions;
        $sectionId = $conditions['section_id'] ?? null;

        if (!$sectionId) {
            return false;
        }

        $section = Section::find($sectionId);
        if (!$section) {
            return false;
        }

        $allTasks = $section->tasks()->pluck('id')->toArray();
        if (empty($allTasks)) {
            return false;
        }

        $completedTasks = $user->userTaskProgress()
            ->whereIn('task_id', $allTasks)
            ->count();

        return $completedTasks === count($allTasks);
    }

    private static function checkAllSectionsAchievement(User $user, Achievement $achievement): bool
    {
        $sections = Section::all();

        foreach ($sections as $section) {
            $allTasks = $section->tasks()->pluck('id')->toArray();
            if (empty($allTasks)) {
                continue;
            }

            $completedTasks = $user->userTaskProgress()
                ->whereIn('task_id', $allTasks)
                ->count();

            if ($completedTasks !== count($allTasks)) {
                return false;
            }
        }

        return true;
    }

    public static function unlockAchievement(User $user, Achievement $achievement)
    {
        if (!$user->achievements()->where('achievement_id', $achievement->id)->exists()) {
            $user->achievements()->attach($achievement->id, [
                'unlocked_at' => now()
            ]);

            // Можно добавить уведомление
            self::notifyAboutAchievement($user, $achievement);
        }
    }

    private static function notifyAboutAchievement(User $user, Achievement $achievement)
    {
        // Здесь можно реализовать отправку уведомления
        // Например, через веб-сокеты или в сессию
        session()->flash('achievement_unlocked', [
            'title' => $achievement->title,
            'description' => $achievement->description,
            'icon' => $achievement->icon,
        ]);
    }

    // Вызывать этот метод после завершения задания
    public static function onTaskCompleted(User $user)
    {
        self::checkAndUnlockAchievements($user);
    }
}
