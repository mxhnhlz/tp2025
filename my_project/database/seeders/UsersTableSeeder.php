<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Создаем тестового пользователя
        User::create([
            'name' => 'Тестовый Юзер',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'level' => 1,
            'xp' => 100,
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Создаем администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'level' => 10,
            'xp' => 5000,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Еще несколько тестовых пользователей
        User::create([
            'name' => 'Иван Петров',
            'email' => 'ivan@example.com',
            'password' => Hash::make('password123'),
            'level' => 3,
            'xp' => 500,
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Мария Сидорова',
            'email' => 'maria@example.com',
            'password' => Hash::make('password123'),
            'level' => 5,
            'xp' => 1200,
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        echo "Создано 4 тестовых пользователя\n";
    }
}
