@extends('layouts.app')

@section('content')
<!-- Приветственный баннер для аутентифицированного пользователя -->
<div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <svg class="absolute left-full transform -translate-y-3/4 -translate-x-1/4 md:-translate-y-1/2 lg:-translate-x-1/2" width="404" height="784" fill="none" viewBox="0 0 404 784">
            <defs>
                <pattern id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" class="text-indigo-500" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="404" height="784" fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)" />
        </svg>
    </div>
    <div class="relative z-10 container mx-auto px-4 py-16 md:py-24 lg:py-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div class="text-center md:text-left" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <div x-show="show"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-4">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                        Здравствуйте, <span class="text-blue-300">{{ Auth::user()->name }}</span>!
                    </h1>
                    <p class="text-blue-100 text-lg md:text-xl max-w-xl">
                        @if(Auth::user()->role === 'teacher')
                            Управляйте своими курсами и следите за прогрессом студентов
                        @elseif(Auth::user()->role === 'student')
                            Продолжайте обучение или изучите новые курсы
                        @else
                            Добро пожаловать в личный кабинет
                        @endif
                    </p>
                    <div class="pt-4 flex flex-wrap gap-4 justify-center md:justify-start">
                        @if(Auth::user()->role === 'teacher')
                            <a href="{{ route('teacher.courses.index') }}" class="px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition shadow-md">
                                Мои курсы
                            </a>
                            <a href="{{ route('teacher.dashboard') }}" class="px-6 py-3 bg-transparent border border-white text-white font-medium rounded-lg hover:bg-white/10 transition">
                                Перейти в панель
                            </a>
                        @elseif(Auth::user()->role === 'student')
                            <a href="{{ route('student.courses') }}" class="px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition shadow-md">
                                Мои курсы
                            </a>
                            <a href="#popular-courses" class="px-6 py-3 bg-transparent border border-white text-white font-medium rounded-lg hover:bg-white/10 transition">
                                Популярные курсы
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="hidden md:block relative" x-data="{ show: false }" x-init="setTimeout(() => show = true, 400)">
                <div x-show="show"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0">
                    <img src="{{ asset('images/hero-image.svg') }}" alt="Онлайн обучение" class="w-full h-auto max-w-lg mx-auto">
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role === 'student')
    <!-- Мои курсы (для студента) -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Мои курсы</h2>
                    <p class="text-gray-600 max-w-2xl">Продолжайте обучение с того места, где остановились</p>
                </div>
                <a href="{{ route('student.courses') }}" class="hidden md:flex items-center text-blue-600 hover:text-blue-800 transition">
                    Все мои курсы
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(isset($userData['enrolledCourses']) && $userData['enrolledCourses']->count() > 0)
                    @foreach($userData['enrolledCourses'] as $course)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                            <div class="h-48 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center relative">
                                @if($course->image)
                                    <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-white font-bold text-xl">{{ $course->title }}</div>
                                @endif
                                <div class="absolute bottom-0 right-0 bg-blue-600 text-white px-3 py-1 text-sm font-semibold">
                                    {{ $course->pivot->progress }}% пройдено
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 text-gray-900">{{ $course->title }}</h3>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                                        {{ $course->category->name ?? 'Категория' }}
                                    </div>
                                    <a href="{{ route('student.courses.study', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Продолжить</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">У вас пока нет курсов</h3>
                        <p class="text-gray-600 mb-4">Запишитесь на курсы, чтобы начать обучение.</p>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg">
                            Найти курсы
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@elseif(Auth::user()->role === 'teacher')
    <!-- Мои курсы (для преподавателя) -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Мои курсы</h2>
                    <p class="text-gray-600 max-w-2xl">Курсы, которые вы ведете</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('teacher.courses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Создать курс
                    </a>
                    <a href="{{ route('teacher.courses.index') }}" class="hidden md:flex items-center text-blue-600 hover:text-blue-800 transition">
                        Все мои курсы
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(isset($userData['myCourses']) && $userData['myCourses']->count() > 0)
                    @foreach($userData['myCourses'] as $course)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                            <div class="h-48 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center relative">
                                @if($course->image)
                                    <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-white font-bold text-xl">{{ $course->title }}</div>
                                @endif
                                <div class="absolute bottom-0 right-0 bg-{{ $course->status === 'published' ? 'green' : 'yellow' }}-600 text-white px-3 py-1 text-sm font-semibold">
                                    {{ $course->status === 'published' ? 'Опубликован' : 'Черновик' }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 text-gray-900">{{ $course->title }}</h3>
                                <div class="flex justify-between items-center mt-4">
                                    <div class="text-gray-600 text-sm">{{ $course->students_count ?? 0 }} студентов</div>
                                    <a href="{{ route('teacher.courses.edit', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm">Редактировать</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">У вас пока нет созданных курсов</h3>
                        <p class="text-gray-600 mb-4">Создайте свой первый курс, чтобы начать обучать.</p>
                        <a href="{{ route('teacher.courses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg">
                            Создать курс
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Популярные курсы -->
<div id="popular-courses" class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Популярные курсы</h2>
                <p class="text-gray-600 max-w-2xl">Выбирайте из наших наиболее востребованных программ обучения</p>
            </div>
            <a href="{{ route('courses.index') }}" class="hidden md:flex items-center text-blue-600 hover:text-blue-800 transition">
                Все курсы
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(count($popularCourses) > 0)
                @foreach($popularCourses as $course)
                    <x-course-card :course="$course" />
                @endforeach
            @else
                <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Популярные курсы не найдены</h3>
                    <p class="text-gray-600 mb-4">В данный момент нет популярных курсов.</p>
                </div>
            @endif
        </div>

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                Все курсы
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Новые курсы -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Новые курсы</h2>
                <p class="text-gray-600 max-w-2xl">Ознакомьтесь с нашими новыми программами обучения</p>
            </div>
            <a href="{{ route('courses.index') }}" class="hidden md:flex items-center text-blue-600 hover:text-blue-800 transition">
                Все курсы
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(count($newCourses) > 0)
                @foreach($newCourses as $course)
                    <x-course-card :course="$course" />
                @endforeach
            @else
                <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Новые курсы не найдены</h3>
                    <p class="text-gray-600 mb-4">В данный момент нет новых курсов.</p>
                </div>
            @endif
        </div>

        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                Все курсы
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Категории -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Изучайте по категориям</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Выберите интересующую вас область обучения</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category->id]) }}"
                   class="bg-white rounded-lg p-6 text-center hover:shadow-md transition duration-300 flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-900">{{ $category->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1">{{ $category->courses_count ?? 0 }} курсов</p>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Призыв к действию -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-6">Готовы начать обучение?</h2>
        <p class="text-blue-100 text-lg max-w-2xl mx-auto mb-8">Присоединяйтесь к нашему сообществу студентов уже сегодня и откройте для себя мир новых возможностей</p>
        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition shadow-md">
            Зарегистрироваться бесплатно
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
</div>
@endsection
