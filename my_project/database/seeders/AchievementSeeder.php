<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            [
                'slug' => 'first_task',
                'title' => 'Первое задание',
                'description' => 'Пройдите первое задание',
                'type' => 'tasks_count',
                'conditions' => json_encode(['count' => 1]),
                'icon' => 'trophy',
                'xp_reward' => 100,
            ],
            [
                'slug' => 'five_tasks',
                'title' => 'Пятерка',
                'description' => 'Пройдите 5 заданий',
                'type' => 'tasks_count',
                'conditions' => json_encode(['count' => 5]),
                'icon' => 'star',
                'xp_reward' => 300,
            ],
            [
                'slug' => 'perfectionist',
                'title' => 'Перфекционист',
                'description' => 'Пройдите задание с точностью 100%',
                'type' => 'accuracy',
                'conditions' => json_encode(['accuracy' => 100]),
                'icon' => 'target',
                'xp_reward' => 500,
            ],
            [
                'slug' => 'quick_learner',
                'title' => 'Быстрый ученик',
                'description' => 'Пройдите 3 задания за один день',
                'type' => 'tasks_count',
                'conditions' => json_encode(['count' => 3]),
                'icon' => 'zap',
                'xp_reward' => 250,
            ],
            [
                'slug' => 'cyber_expert',
                'title' => 'Эксперт по кибербезопасности',
                'description' => 'Достигните 10 уровня',
                'type' => 'level',
                'conditions' => json_encode(['level' => 10]),
                'icon' => 'shield',
                'xp_reward' => 1000,
            ],
            [
                'slug' => 'perfectionist',
                'title' => 'Перфекционист',
                'description' => 'Пройдите задание с точностью 100%',
                'type' => 'accuracy',
                'conditions' => json_encode(['accuracy' => 100, 'count' => 1]),
                'icon' => 'target',
                'xp_reward' => 300,
            ],
            [
                'slug' => 'expert_analyst',
                'title' => 'Эксперт-аналитик',
                'description' => 'Средняя точность по всем заданиям 90% или выше',
                'type' => 'accuracy_average',
                'conditions' => json_encode(['accuracy' => 90]),
                'icon' => 'bar-chart',
                'xp_reward' => 500,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
