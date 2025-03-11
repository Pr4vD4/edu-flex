@extends('layouts.app')

@section('content')
<!-- Главный баннер - с новым классом для стилей -->
<div class="relative bg-gradient-to-r from-blue-600 to-indigo-800 text-white overflow-hidden welcome-banner">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative pt-16 pb-20 md:pt-24 md:pb-28 lg:pt-32 lg:pb-36">
            <div class="text-center md:text-left max-w-2xl md:max-w-3xl mx-auto md:mx-0">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight mb-4">
                    Образование для будущего
                </h1>
                <p class="text-lg md:text-xl lg:text-2xl mb-8 text-blue-100">
                    Учитесь у лучших преподавателей, получайте востребованные навыки, меняйте свою карьеру.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('courses.index') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 shadow-md transition duration-150">
                        Найти курсы
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-blue-700 transition duration-150">
                        Начать обучение
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Декоративный элемент -->
    <div class="hidden lg:block absolute right-0 inset-y-0 w-1/3">
        <svg class="h-full w-full text-blue-700 opacity-20" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
            <polygon points="0,0 100,0 50,100 0,100" />
        </svg>
    </div>
</div>

<!-- Преимущества платформы -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Преимущества EduFlex
            </h2>
            <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-500">
                Наша платформа создана для эффективного обучения и развития
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-blue-50 rounded-lg p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-600 rounded-full p-3 text-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div class="ml-4 text-lg font-semibold text-gray-900">Онлайн обучение</div>
                </div>
                <p class="text-gray-600">
                    Получите доступ к курсам, заданиям и материалам в любое время и из любого места.
                </p>
            </div>

            <div class="bg-indigo-50 rounded-lg p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-600 rounded-full p-3 text-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="ml-4 text-lg font-semibold text-gray-900">Интерактивные материалы</div>
                </div>
                <p class="text-gray-600">
                    Видеоуроки, тесты, практические задания и многое другое для эффективного обучения.
                </p>
            </div>

            <div class="bg-purple-50 rounded-lg p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-600 rounded-full p-3 text-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    </div>
                    <div class="ml-4 text-lg font-semibold text-gray-900">Общение и поддержка</div>
                </div>
                <p class="text-gray-600">
                    Получайте мгновенную обратную связь, задавайте вопросы и участвуйте в дискуссиях.
                </p>
            </div>

            <div class="bg-green-50 rounded-lg p-6 hover:shadow-lg transition duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-green-600 rounded-full p-3 text-white">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h.5A2.5 2.5 0 0020 5.5v-1.65"></path></svg>
                    </div>
                    <div class="ml-4 text-lg font-semibold text-gray-900">Гибкое расписание</div>
                </div>
                <p class="text-gray-600">
                    Учитесь в удобное для вас время, создавая индивидуальное расписание и отслеживая прогресс.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Популярные курсы -->
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Популярные курсы</h2>
            <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                Все курсы
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Заглушки для курсов -->
            @for ($i = 1; $i <= 3; $i++)
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
                <div class="aspect-w-16 aspect-h-9 bg-gray-300">
                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold">
                        Курс {{ $i }}
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Категория</span>
                        <span class="text-sm text-gray-500">{{ rand(10, 100) }} учеников</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Название популярного курса {{ $i }}</h3>
                    <p class="text-gray-600 mb-4">Краткое описание курса, который поможет вам освоить новые навыки и развить профессиональные компетенции.</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xs font-bold">АП</div>
                            <span class="ml-2 text-sm text-gray-700">Автор Преподаватель</span>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Подробнее</a>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<!-- Новые курсы -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Новые курсы</h2>
            <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                Все курсы
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Заглушки для новых курсов -->
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 border border-gray-200">
                <div class="aspect-w-16 aspect-h-9 bg-gray-300">
                    <div class="w-full h-40 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white font-bold">
                        Новый курс {{ $i }}
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Новый курс {{ $i }}</h3>
                    <p class="text-gray-600 text-sm mb-3">Открывайте новые возможности с нашими курсами.</p>
                    <a href="#" class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">Подробнее</a>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<!-- Присоединяйтесь к обучению -->
<div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold mb-4">Готовы начать обучение?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">Присоединяйтесь к тысячам студентов, которые уже развивают свои навыки с EduFlex</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 shadow-md transition duration-150">
                Зарегистрироваться
            </a>
            <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-indigo-700 transition duration-150">
                Войти в систему
            </a>
        </div>
    </div>
</div>
@endsection
