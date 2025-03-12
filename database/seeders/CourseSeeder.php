<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем категории и преподавателей
        $categories = Category::all();
        $teachers = User::where('role', 'teacher')->get();

        // Массив с данными для курсов
        $courses = [
            [
                'title' => 'Основы программирования на Python',
                'description' => 'В этом курсе вы изучите основы языка программирования Python, который является одним из самых популярных языков для начинающих программистов.',
                'price' => 2000,
                'category_id' => $categories->where('name', 'Программирование')->first()->id,
                'teacher_id' => $teachers[0]->id,
                'is_published' => true,
            ],
            [
                'title' => 'HTML и CSS для начинающих',
                'description' => 'Изучите основы HTML и CSS для создания современных веб-сайтов. Этот курс подходит для полных новичков.',
                'price' => 1500,
                'category_id' => $categories->where('name', 'Программирование')->first()->id,
                'teacher_id' => $teachers[0]->id,
                'is_published' => true,
            ],
            [
                'title' => 'JavaScript для фронтенд-разработчиков',
                'description' => 'Изучите JavaScript — язык программирования, который позволяет создавать динамические веб-приложения.',
                'price' => 3000,
                'category_id' => $categories->where('name', 'Программирование')->first()->id,
                'teacher_id' => $teachers[0]->id,
                'is_published' => true,
            ],
            [
                'title' => 'Графический дизайн в Adobe Photoshop',
                'description' => 'Освойте графический дизайн с помощью Adobe Photoshop - самой популярной программы для редактирования изображений.',
                'price' => 2500,
                'category_id' => $categories->where('name', 'Дизайн')->first()->id,
                'teacher_id' => $teachers[1]->id,
                'is_published' => true,
            ],
            [
                'title' => 'UI/UX дизайн: от новичка до профессионала',
                'description' => 'Научитесь создавать удобные и красивые интерфейсы для веб-сайтов и мобильных приложений.',
                'price' => 4000,
                'category_id' => $categories->where('name', 'Дизайн')->first()->id,
                'teacher_id' => $teachers[1]->id,
                'is_published' => true,
            ],
            [
                'title' => 'Основы цифрового маркетинга',
                'description' => 'Изучите основы цифрового маркетинга, включая SEO, контент-маркетинг и социальные сети.',
                'price' => 2300,
                'category_id' => $categories->where('name', 'Маркетинг')->first()->id,
                'teacher_id' => $teachers[2]->id,
                'is_published' => true,
            ],
            [
                'title' => 'Анализ данных в Python',
                'description' => 'Научитесь анализировать данные с помощью Python, используя библиотеки Pandas, NumPy и Matplotlib.',
                'price' => 3500,
                'category_id' => $categories->where('name', 'Наука о данных')->first()->id,
                'teacher_id' => $teachers[0]->id,
                'is_published' => true,
            ],
            [
                'title' => 'Основы машинного обучения',
                'description' => 'Изучите основы машинного обучения и искусственного интеллекта на практических примерах.',
                'price' => 4500,
                'category_id' => $categories->where('name', 'Наука о данных')->first()->id,
                'teacher_id' => $teachers[0]->id,
                'is_published' => false,
            ],
            [
                'title' => 'Английский язык для программистов',
                'description' => 'Специализированный курс английского языка для IT-специалистов и программистов.',
                'price' => 1800,
                'category_id' => $categories->where('name', 'Иностранные языки')->first()->id,
                'teacher_id' => $teachers[2]->id,
                'is_published' => true,
            ],
            [
                'title' => 'Как запустить свой стартап',
                'description' => 'Пошаговое руководство по запуску собственного бизнеса от идеи до реализации.',
                'price' => 3800,
                'category_id' => $categories->where('name', 'Бизнес')->first()->id,
                'teacher_id' => $teachers[1]->id,
                'is_published' => true,
            ],
        ];

        // Создаем курсы
        foreach ($courses as $courseData) {
            Course::create([
                'title' => $courseData['title'],
                'slug' => Str::slug($courseData['title']) . '-' . rand(1000, 9999),
                'description' => $courseData['description'],
                'price' => $courseData['price'],
                'category_id' => $courseData['category_id'],
                'teacher_id' => $courseData['teacher_id'],
                'is_published' => $courseData['is_published'],
            ]);
        }
    }
}
