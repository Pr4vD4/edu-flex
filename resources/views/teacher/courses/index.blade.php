@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Мои курсы</h1>
            <a href="{{ route('teacher.courses.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Создать новый курс
            </a>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if ($courses->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <p class="mb-4">У вас еще нет созданных курсов.</p>
                    <a href="{{ route('teacher.courses.create') }}" class="text-blue-600 hover:underline">
                        Создать первый курс
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($courses as $course)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                        <div class="relative">
                            @if ($course->image)
                                <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Нет изображения</span>
                                </div>
                            @endif

                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs rounded-full {{ $course->is_published ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                    {{ $course->is_published ? 'Опубликован' : 'Черновик' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $course->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4 h-12 overflow-hidden">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <div class="border-t pt-4 flex flex-wrap gap-2">
                                <a href="{{ route('teacher.courses.edit', $course) }}" class="text-blue-600 hover:underline text-sm">
                                    Редактировать
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-blue-600 hover:underline text-sm">
                                    Уроки ({{ $course->lessons->count() }})
                                </a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('teacher.courses.students', $course) }}" class="text-blue-600 hover:underline text-sm">
                                    Студенты ({{ $course->students->count() }})
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
