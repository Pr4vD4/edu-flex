<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Создаем преподавателей
        $teachers = [
            [
                'name' => 'Иван Петров',
                'email' => 'teacher1@example.com',
            ],
            [
                'name' => 'Елена Сидорова',
                'email' => 'teacher2@example.com',
            ],
            [
                'name' => 'Александр Иванов',
                'email' => 'teacher3@example.com',
            ],
        ];

        foreach ($teachers as $teacher) {
            User::create([
                'name' => $teacher['name'],
                'email' => $teacher['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]);
        }

        // Создаем студентов
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'Студент ' . $i,
                'email' => 'student' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);
        }
    }
}
