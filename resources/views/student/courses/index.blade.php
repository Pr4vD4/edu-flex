@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Мои курсы</h1>
            <p class="text-gray-600 mt-1">Здесь отображаются все курсы, на которые вы записаны</p>
        </div>

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

        @if($courses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            @if($course->image)
                                <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $course->lessons_count ?? 0 }} уроков
                            </div>
                            @php
                                $enrollmentData = Auth::user()->enrollments->where('course_id', $course->id)->first();
                                $progress = $enrollmentData ? $enrollmentData->progress : 0;
                            @endphp
                            <div class="absolute bottom-0 left-0 right-0 bg-gray-900 bg-opacity-75 text-white p-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span>Прогресс: {{ $progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-blue-600 uppercase">
                                    {{ $course->category ? $course->category->name : 'Без категории' }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $course->students_count ?? 0 }} студентов</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                            <div class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ Str::limit($course->description, 100) }}
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full object-cover mr-2" src="https://ui-avatars.com/api/?name={{ urlencode($course->teacher ? $course->teacher->name : 'Unknown') }}&color=7F9CF5&background=EBF4FF" alt="{{ $course->teacher ? $course->teacher->name : 'Unknown' }}">
                                    <span class="text-sm text-gray-700">{{ $course->teacher ? $course->teacher->name : 'Неизвестный преподаватель' }}</span>
                                </div>
                                <a href="{{ route('student.courses.study', $course) }}" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Перейти</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $courses->links() }}
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">У вас пока нет курсов</h3>
                <p class="text-gray-600 mb-4">Запишитесь на курсы, чтобы начать обучение</p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                    Просмотреть доступные курсы
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
