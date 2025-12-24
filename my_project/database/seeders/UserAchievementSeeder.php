<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAchievementSeeder extends Seeder
{
    public function run(): void
    {
        // Находим ваших пользователей
        $admin = User::where('email', 'admin2@mail.com')->first();
        $user = User::where('email', 'test@gmail.com')->first();

        // Находим достижения по их slug (из вашего предыдущего сидера)
        $firstTask = Achievement::where('slug', 'first_task')->first();
        $perfectionist = Achievement::where('slug', 'perfectionist')->first();

        // Список привязок
        $assignments = [
            ['user' => $admin, 'achievement' => $firstTask],
            ['user' => $admin, 'achievement' => $perfectionist],
            ['user' => $user, 'achievement' => $firstTask],
        ];

        foreach ($assignments as $item) {
            if ($item['user'] && $item['achievement']) {
                // Используем updateOrInsert, чтобы не создавать дубликатов
                DB::table('user_achievements')->updateOrInsert(
                    [
                        'user_id' => $item['user']->id,
                        'achievement_id' => $item['achievement']->id,
                    ],
                    [
                        'unlocked_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
