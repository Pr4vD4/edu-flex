<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем все курсы
        $courses = Course::all();

        // Для каждого курса создаем уроки
        foreach ($courses as $course) {
            // Создаем тематическое содержание в зависимости от курса
            if (strpos($course->title, 'Python') !== false) {
                $this->createPythonLessons($course);
            } elseif (strpos($course->title, 'HTML') !== false) {
                $this->createHtmlCssLessons($course);
            } elseif (strpos($course->title, 'JavaScript') !== false) {
                $this->createJavaScriptLessons($course);
            } elseif (strpos($course->title, 'Photoshop') !== false) {
                $this->createPhotoshopLessons($course);
            } elseif (strpos($course->title, 'UI/UX') !== false) {
                $this->createUiUxLessons($course);
            } else {
                // Для остальных курсов создаем обобщенные уроки
                $this->createGenericLessons($course);
            }
        }
    }

    /**
     * Создает уроки для курса по Python
     */
    private function createPythonLessons(Course $course): void
    {
        $lessons = [
            [
                'title' => 'Введение в Python',
                'description' => 'Знакомство с Python, его особенностями и областями применения',
                'content' => 'Подробный контент урока о Python...',
                'position' => 1,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Переменные и типы данных',
                'description' => 'Изучение основных типов данных в Python и работы с переменными',
                'content' => 'Подробный контент урока о переменных и типах данных...',
                'position' => 2,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Условные операторы и циклы',
                'description' => 'Изучение условных операторов if-else и циклов for/while',
                'content' => 'Подробный контент урока об условных операторах и циклах...',
                'position' => 3,
                'duration_minutes' => 75,
            ],
            [
                'title' => 'Функции и модули',
                'description' => 'Создание и использование функций, импорт модулей',
                'content' => 'Подробный контент урока о функциях и модулях...',
                'position' => 4,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Работа с файлами',
                'description' => 'Чтение и запись файлов в Python',
                'content' => 'Подробный контент урока о работе с файлами...',
                'position' => 5,
                'duration_minutes' => 45,
            ],
        ];

        $this->createLessons($course, $lessons);
    }

    /**
     * Создает уроки для курса по HTML и CSS
     */
    private function createHtmlCssLessons(Course $course): void
    {
        $lessons = [
            [
                'title' => 'Основы HTML',
                'description' => 'Введение в HTML, структура документа, основные теги',
                'content' => 'Подробный контент урока об основах HTML...',
                'position' => 1,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Работа с текстом и ссылками',
                'description' => 'Форматирование текста, создание списков и ссылок',
                'content' => 'Подробный контент урока о работе с текстом и ссылками...',
                'position' => 2,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Введение в CSS',
                'description' => 'Основы CSS, подключение стилей, селекторы',
                'content' => 'Подробный контент урока о CSS...',
                'position' => 3,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Блочная модель и позиционирование',
                'description' => 'Изучение блочной модели CSS и способов позиционирования элементов',
                'content' => 'Подробный контент урока о блочной модели...',
                'position' => 4,
                'duration_minutes' => 75,
            ],
            [
                'title' => 'Адаптивный дизайн',
                'description' => 'Создание адаптивных веб-страниц с помощью медиа-запросов',
                'content' => 'Подробный контент урока об адаптивном дизайне...',
                'position' => 5,
                'duration_minutes' => 60,
            ],
        ];

        $this->createLessons($course, $lessons);
    }

    /**
     * Создает уроки для курса по JavaScript
     */
    private function createJavaScriptLessons(Course $course): void
    {
        $lessons = [
            [
                'title' => 'Основы JavaScript',
                'description' => 'Введение в JavaScript, синтаксис, переменные и типы данных',
                'content' => 'Подробный контент урока об основах JavaScript...',
                'position' => 1,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Условия и циклы',
                'description' => 'Изучение условных операторов и циклов в JavaScript',
                'content' => 'Подробный контент урока об условиях и циклах...',
                'position' => 2,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Функции и объекты',
                'description' => 'Создание и использование функций, работа с объектами',
                'content' => 'Подробный контент урока о функциях и объектах...',
                'position' => 3,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'DOM-манипуляции',
                'description' => 'Работа с DOM-элементами, изменение содержимого страницы',
                'content' => 'Подробный контент урока о DOM-манипуляциях...',
                'position' => 4,
                'duration_minutes' => 75,
            ],
            [
                'title' => 'События и обработчики',
                'description' => 'Работа с событиями, создание интерактивных элементов',
                'content' => 'Подробный контент урока о событиях...',
                'position' => 5,
                'duration_minutes' => 60,
            ],
        ];

        $this->createLessons($course, $lessons);
    }

    /**
     * Создает уроки для курса по Photoshop
     */
    private function createPhotoshopLessons(Course $course): void
    {
        $lessons = [
            [
                'title' => 'Интерфейс Photoshop',
                'description' => 'Знакомство с интерфейсом Photoshop, основные инструменты',
                'content' => 'Подробный контент урока об интерфейсе Photoshop...',
                'position' => 1,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Работа со слоями',
                'description' => 'Создание и управление слоями, режимы наложения',
                'content' => 'Подробный контент урока о работе со слоями...',
                'position' => 2,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Основы ретуши фотографий',
                'description' => 'Техники ретуши фотографий, инструменты коррекции',
                'content' => 'Подробный контент урока о ретуши...',
                'position' => 3,
                'duration_minutes' => 75,
            ],
            [
                'title' => 'Работа с текстом',
                'description' => 'Создание и форматирование текста, текстовые эффекты',
                'content' => 'Подробный контент урока о работе с текстом...',
                'position' => 4,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Создание рекламного баннера',
                'description' => 'Практическое занятие по созданию рекламного баннера',
                'content' => 'Подробный контент урока о создании баннера...',
                'position' => 5,
                'duration_minutes' => 90,
            ],
        ];

        $this->createLessons($course, $lessons);
    }

    /**
     * Создает уроки для курса по UI/UX дизайну
     */
    private function createUiUxLessons(Course $course): void
    {
        $lessons = [
            [
                'title' => 'Основы UX дизайна',
                'description' => 'Введение в UX дизайн, основные принципы и подходы',
                'content' => 'Подробный контент урока об основах UX дизайна...',
                'position' => 1,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Исследование пользователей',
                'description' => 'Методы исследования пользователей, создание персон',
                'content' => 'Подробный контент урока об исследовании пользователей...',
                'position' => 2,
                'duration_minutes' => 75,
            ],
            [
                'title' => 'Основы UI дизайна',
                'description' => 'Введение в UI дизайн, визуальные элементы интерфейса',
                'content' => 'Подробный контент урока об основах UI дизайна...',
                'position' => 3,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Прототипирование',
                'description' => 'Создание прототипов интерфейса, инструменты прототипирования',
                'content' => 'Подробный контент урока о прототипировании...',
                'position' => 4,
                'duration_minutes' => 90,
            ],
            [
                'title' => 'Тестирование пользовательского интерфейса',
                'description' => 'Методы тестирования UI/UX, сбор и анализ обратной связи',
                'content' => 'Подробный контент урока о тестировании...',
                'position' => 5,
                'duration_minutes' => 75,
            ],
        ];

        $this->createLessons($course, $lessons);
    }

    /**
     * Создает общие уроки для остальных курсов
     */
    private function createGenericLessons(Course $course): void
    {
        $lessons = [
            [
                'title' => 'Введение в ' . $course->title,
                'description' => 'Введение в курс, основные понятия и темы',
                'content' => 'Подробный контент вводного урока...',
                'position' => 1,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Основы ' . $course->title,
                'description' => 'Изучение основных концепций и принципов',
                'content' => 'Подробный контент урока об основах...',
                'position' => 2,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Практическое применение знаний',
                'description' => 'Применение полученных знаний на практике',
                'content' => 'Подробный контент урока о практическом применении...',
                'position' => 3,
                'duration_minutes' => 75,
            ],
            [
                'title' => 'Продвинутые техники',
                'description' => 'Изучение продвинутых техник и методов',
                'content' => 'Подробный контент урока о продвинутых техниках...',
                'position' => 4,
                'duration_minutes' => 60,
            ],
            [
                'title' => 'Финальный проект',
                'description' => 'Работа над финальным проектом, закрепление материала',
                'content' => 'Подробный контент урока о финальном проекте...',
                'position' => 5,
                'duration_minutes' => 90,
            ],
        ];

        $this->createLessons($course, $lessons);
    }

    /**
     * Создает уроки для курса
     */
    private function createLessons(Course $course, array $lessons): void
    {
        foreach ($lessons as $lessonData) {
            Lesson::create([
                'title' => $lessonData['title'],
                'description' => $lessonData['description'],
                'content' => $lessonData['content'],
                'course_id' => $course->id,
                'position' => $lessonData['position'],
                'is_published' => $course->is_published,
                'duration_minutes' => $lessonData['duration_minutes'],
            ]);
        }
    }
}
