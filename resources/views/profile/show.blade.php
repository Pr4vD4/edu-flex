@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Мой профиль</h1>

                @if (session('status'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                @endif

                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 p-4">
                        <div class="bg-gray-50 rounded-lg p-6 shadow">
                            <div class="text-center mb-4">
                                <div class="w-24 h-24 mx-auto bg-gray-300 rounded-full flex items-center justify-center text-gray-700 text-3xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <h2 class="mt-4 text-xl font-semibold">{{ $user->name }}</h2>
                                <p class="text-gray-600">{{ $user->email }}</p>

                                <div class="mt-2">
                                    <span class="px-3 py-1 text-xs text-white rounded-full
                                        @if($user->role === 'admin') bg-red-500
                                        @elseif($user->role === 'teacher') bg-purple-500
                                        @else bg-blue-500 @endif">
                                        @if($user->role === 'admin') Администратор
                                        @elseif($user->role === 'teacher') Преподаватель
                                        @else Студент @endif
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('profile.edit') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-center py-2 px-4 rounded text-gray-700 mb-2">
                                    Редактировать профиль
                                </a>
                                <a href="{{ route('profile.password') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-center py-2 px-4 rounded text-gray-700">
                                    Изменить пароль
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-2/3 p-4">
                        <div class="bg-white rounded-lg p-6 shadow border border-gray-200">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Информация о пользователе</h3>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Имя</p>
                                <p class="text-gray-800">{{ $user->name }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-800">{{ $user->email }}</p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Роль</p>
                                <p class="text-gray-800">
                                    @if($user->role === 'admin') Администратор
                                    @elseif($user->role === 'teacher') Преподаватель
                                    @else Студент @endif
                                </p>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Дата регистрации</p>
                                <p class="text-gray-800">{{ $user->created_at->format('d.m.Y') }}</p>
                            </div>
                        </div>

                        @if($user->isStudent())
                        <div class="bg-white rounded-lg p-6 shadow border border-gray-200 mt-4">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Мои курсы</h3>

                            @if($user->enrolledCourses->count() > 0)
                                <div class="space-y-3">
                                    @foreach($user->enrolledCourses as $course)
                                        <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center">
                                            <div>
                                                <h4 class="font-medium">{{ $course->title }}</h4>
                                                <div class="text-sm text-gray-500">Прогресс: {{ $course->pivot->progress }}%</div>
                                            </div>
                                            <a href="{{ route('student.courses.study', $course) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                                                Перейти
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">Вы пока не записаны ни на один курс.</p>
                            @endif
                        </div>
                        @endif

                        @if($user->isTeacher())
                        <div class="bg-white rounded-lg p-6 shadow border border-gray-200 mt-4">
                            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Мои курсы</h3>

                            @if($user->teacherCourses->count() > 0)
                                <div class="space-y-3">
                                    @foreach($user->teacherCourses as $course)
                                        <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center">
                                            <div>
                                                <h4 class="font-medium">{{ $course->title }}</h4>
                                                <div class="text-sm text-gray-500">
                                                    @if($course->is_published)
                                                        <span class="text-green-600">Опубликован</span>
                                                    @else
                                                        <span class="text-yellow-600">Черновик</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <a href="{{ route('teacher.courses.edit', $course) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                                                Редактировать
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">У вас пока нет созданных курсов.</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
