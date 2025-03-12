@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700">
    <div class="container mx-auto px-4 py-12">
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="w-full md:w-1/2">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center text-blue-100 hover:text-white mb-4 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Назад к каталогу
                </a>

                <span class="px-3 py-1 text-xs bg-blue-500 text-white rounded-full mb-4 inline-block">
                    @if($course->category)
                    <a href="{{ route('categories.show', $course->category->slug) }}" class="text-white hover:text-blue-100">
                        {{ $course->category->name }}
                    </a>
                    @else
                    <span class="text-white">Без категории</span>
                    @endif
                </span>

                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $course->title }}</h1>

                <div class="flex items-center mb-6">
                    @if($course->teacher)
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($course->teacher->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $course->teacher->name }}">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $course->teacher->name }}</p>
                        <p class="text-xs text-blue-100">Преподаватель</p>
                    </div>
                    @else
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Unknown&color=7F9CF5&background=EBF4FF" alt="Неизвестный преподаватель">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Неизвестный преподаватель</p>
                        <p class="text-xs text-blue-100">Преподаватель</p>
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap gap-4 mb-6">
                    <div class="flex items-center text-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $course->duration ?? '?' }} мин</span>
                    </div>

                    <div class="flex items-center text-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>{{ $course->students_count }} студентов</span>
                    </div>

                    <div class="flex items-center text-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span>{{ rand(3, 15) }} уроков</span>
                    </div>
                </div>

                <div class="bg-white/10 p-4 rounded-lg backdrop-blur-sm mb-6">
                    <p class="text-blue-50">{{ $course->description }}</p>
                </div>

                <div>
                    @if($course->price > 0)
                        <div class="text-2xl font-bold text-white mb-4">{{ number_format($course->price, 0, '.', ' ') }} ₽</div>
                    @else
                        <div class="text-2xl font-bold text-white mb-4">Бесплатно</div>
                    @endif

                    @auth
                        @if(Auth::user()->enrolledCourses && Auth::user()->enrolledCourses->contains($course->id))
                            <a href="{{ route('student.courses') }}" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-indigo-700 transition shadow-lg flex items-center justify-center w-full md:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Перейти к курсу
                            </a>
                        @else
                            <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transition shadow-lg flex items-center justify-center w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Записаться на курс
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg hover:from-green-600 hover:to-emerald-700 transition shadow-lg flex items-center justify-center w-full md:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Войдите для записи на курс
                        </a>
                    @endauth
                </div>
            </div>

            <div class="w-full md:w-1/2">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-auto rounded-lg shadow-lg">
                @else
                    <div class="w-full aspect-video bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg shadow-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-2/3">
            <!-- Вкладки с информацией о курсе -->
            <div x-data="{ tab: 'content' }">
                <div class="border-b border-gray-200 mb-6">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                        <li class="mr-2">
                            <button
                                @click="tab = 'content'"
                                :class="tab === 'content' ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-gray-600 hover:border-gray-300'"
                                class="inline-flex items-center py-4 px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Содержание курса
                            </button>
                        </li>
                        <li class="mr-2">
                            <button
                                @click="tab = 'about'"
                                :class="tab === 'about' ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-gray-600 hover:border-gray-300'"
                                class="inline-flex items-center py-4 px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                О курсе
                            </button>
                        </li>
                        <li class="mr-2">
                            <button
                                @click="tab = 'reviews'"
                                :class="tab === 'reviews' ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-gray-600 hover:border-gray-300'"
                                class="inline-flex items-center py-4 px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Отзывы
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Содержание курса -->
                <div x-show="tab === 'content'" x-transition>
                    <h2 class="text-2xl font-bold mb-6">Содержание курса</h2>

                    <div class="space-y-4">
                        @for($i = 1; $i <= rand(5, 10); $i++)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden" x-data="{ open: false }">
                                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-4 text-left">
                                    <div class="flex items-center">
                                        <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3">{{ $i }}</span>
                                        <span class="font-medium">Модуль {{ $i }}: Тема модуля {{ $i }}</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="open" x-transition class="px-6 pb-4">
                                    <ul class="space-y-2">
                                        @for($j = 1; $j <= rand(3, 5); $j++)
                                            <li class="flex items-center text-gray-600 py-2 border-b border-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                </svg>
                                                <span>Урок {{ $j }}: Название урока {{ $j }}</span>
                                                <span class="ml-auto text-sm text-gray-500">{{ rand(5, 20) }} мин</span>
                                            </li>
                                        @endfor
                                        <li class="flex items-center text-gray-600 py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            <span>Тест по модулю {{ $i }}</span>
                                            <span class="ml-auto text-sm text-gray-500">{{ rand(10, 30) }} мин</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- О курсе -->
                <div x-show="tab === 'about'" x-transition>
                    <h2 class="text-2xl font-bold mb-6">О курсе</h2>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Описание</h3>
                        <div class="prose max-w-none">
                            <p>{{ $course->description }}</p>
                            <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam aliquam, nisl nisl aliquet nisl, eget aliquet nisl nisl eget nisl. Sed euismod, nunc ut aliquam aliquam, nisl nisl aliquet nisl, eget aliquet nisl nisl eget nisl.</p>
                            <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam aliquam, nisl nisl aliquet nisl, eget aliquet nisl nisl eget nisl. Sed euismod, nunc ut aliquam aliquam, nisl nisl aliquet nisl, eget aliquet nisl nisl eget nisl.</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Чему вы научитесь</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @for($i = 1; $i <= 6; $i++)
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Навык {{ $i }}: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold mb-4">Требования</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Базовые знания в области программирования</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Компьютер с доступом в интернет</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Желание учиться и развиваться</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Отзывы -->
                <div x-show="tab === 'reviews'" x-transition>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Отзывы о курсе</h2>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Оставить отзыв</button>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="ml-2 text-lg font-medium">4.0 из 5.0</p>
                            <p class="ml-4 text-sm text-gray-500">({{ rand(10, 100) }} отзывов)</p>
                        </div>

                        <div class="space-y-6">
                            @for($i = 1; $i <= 3; $i++)
                                <div class="bg-white rounded-lg shadow-md p-6">
                                    <div class="flex items-center mb-4">
                                        <img class="h-10 w-10 rounded-full object-cover mr-4" src="https://ui-avatars.com/api/?name=User+{{ $i }}&color=7F9CF5&background=EBF4FF" alt="User {{ $i }}">
                                        <div>
                                            <p class="font-medium">Пользователь {{ $i }}</p>
                                            <p class="text-sm text-gray-500">{{ rand(1, 30) }} {{ ['января', 'февраля', 'марта', 'апреля', 'мая'][rand(0, 4)] }} 2023</p>
                                        </div>
                                        <div class="ml-auto flex">
                                            @for($j = 1; $j <= 5; $j++)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $j <= rand(3, 5) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt scelerisque felis, in pulvinar sapien placerat sed. Nullam euismod felis vitae purus tempus, in dapibus ipsum bibendum.</p>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/3">
            <!-- Информация о преподавателе -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">О преподавателе</h3>

                <div class="flex items-center mb-4">
                    @if($course->teacher)
                    <img class="h-16 w-16 rounded-full object-cover mr-4" src="https://ui-avatars.com/api/?name={{ urlencode($course->teacher->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $course->teacher->name }}">
                    <div>
                        <p class="font-medium text-lg">{{ $course->teacher->name }}</p>
                        <p class="text-sm text-gray-500">Эксперт в области IT</p>
                    </div>
                    @else
                    <img class="h-16 w-16 rounded-full object-cover mr-4" src="https://ui-avatars.com/api/?name=Unknown&color=7F9CF5&background=EBF4FF" alt="Неизвестный преподаватель">
                    <div>
                        <p class="font-medium text-lg">Неизвестный преподаватель</p>
                        <p class="text-sm text-gray-500">Эксперт в области IT</p>
                    </div>
                    @endif
                </div>

                <p class="text-gray-600 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.</p>

                <div class="flex items-center text-sm text-gray-500 mb-4">
                    <div class="flex items-center mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>{{ rand(1000, 5000) }} студентов</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>{{ rand(5, 20) }} курсов</span>
                    </div>
                </div>

                <button class="w-full px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Смотреть профиль
                </button>
            </div>

            <!-- Похожие курсы -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Похожие курсы</h3>

                <div class="space-y-4">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-100 to-indigo-100 rounded flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 hover:text-blue-600 transition">Похожий курс {{ $i }}</h4>
                                <p class="text-sm text-gray-500 mb-1">{{ $course->category ? $course->category->name : 'Без категории' }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="font-medium text-blue-600 mr-2">{{ rand(1000, 5000) }} ₽</span>
                                    <div class="flex">
                                        @for($j = 1; $j <= 5; $j++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $j <= rand(3, 5) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <a href="{{ route('courses.index') }}" class="block mt-6 text-center text-blue-600 hover:text-blue-800 transition">
                    Смотреть все курсы
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
