<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем опубликованные курсы и студентов
        $courses = Course::where('is_published', true)->get();
        $students = User::where('role', 'student')->get();

        // Записываем студентов на курсы
        foreach ($students as $student) {
            // Каждый студент записывается на 2-4 случайных курса
            $coursesCount = rand(2, 4);
            $enrollCourses = $courses->random($coursesCount);

            foreach ($enrollCourses as $course) {
                // Выбираем правильный статус из доступных в enum
                $randomValue = rand(0, 100);
                if ($randomValue > 80) {
                    $status = 'completed';
                } elseif ($randomValue > 20) {
                    $status = 'active';
                } else {
                    $status = 'cancelled';
                }

                // Добавляем запись о зачислении с разным прогрессом
                $student->enrolledCourses()->attach($course->id, [
                    'progress' => rand(0, 100),
                    'status' => $status,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 7)),
                ]);
            }
        }
    }
}
