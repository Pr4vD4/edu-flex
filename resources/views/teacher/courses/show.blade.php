@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $course->title }}</h1>
                    @if(!$course->is_published)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Черновик
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('teacher.courses.edit', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Редактировать курс
                </a>
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Управление уроками
                </a>
                <a href="{{ route('teacher.courses.index') }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Все курсы
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <div class="md:flex">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        @if($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="w-full h-auto rounded-md shadow-sm">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-md">
                                <span class="text-gray-500">Нет изображения</span>
                            </div>
                        @endif

                        <div class="mt-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Статус</div>
                                    <div class="mt-1">
                                        @if($course->is_published)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Опубликован
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Черновик
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Цена</div>
                                    <div class="mt-1">
                                        @if($course->price > 0)
                                            {{ $course->price }} ₽
                                        @else
                                            <span class="text-green-600 font-medium">Бесплатно</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Дата создания</div>
                                    <div class="mt-1">{{ $course->created_at->format('d.m.Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Обновлен</div>
                                    <div class="mt-1">{{ $course->updated_at->format('d.m.Y') }}</div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Уроков</div>
                                    <div class="mt-1">{{ $course->lessons_count }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Студентов</div>
                                    <div class="mt-1">{{ $course->students_count ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:w-2/3 md:pl-8">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Описание курса</h3>
                            <div class="text-gray-700 bg-gray-50 p-4 rounded-md">
                                {!! nl2br(e($course->description)) !!}
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Содержание курса</h3>
                            @if($lessons->isEmpty())
                                <div class="text-center py-6 bg-gray-50 rounded-md">
                                    <p class="text-gray-600">У этого курса пока нет уроков.</p>
                                    <a href="{{ route('teacher.courses.lessons.create', $course) }}" class="mt-2 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Добавить первый урок
                                    </a>
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-md overflow-hidden">
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($lessons as $lesson)
                                            <li class="flex items-center py-3 px-4 hover:bg-gray-100">
                                                <div class="flex-shrink-0 mr-3 text-gray-500 w-6 text-center">
                                                    {{ $lesson->position }}
                                                </div>
                                                <div class="flex-1">
                                                    <a href="{{ route('teacher.courses.lessons.show', [$course, $lesson]) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                                        {{ $lesson->title }}
                                                    </a>
                                                    @if(!$lesson->is_published)
                                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Черновик
                                                        </span>
                                                    @endif
                                                    @if($lesson->description)
                                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($lesson->description, 100) }}</p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm text-gray-500">
                                                    {{ $lesson->duration_minutes ? $lesson->duration_minutes . ' мин.' : '' }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот курс? Все уроки и материалы будут удалены безвозвратно.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Удалить курс
                </button>
            </form>

            @if(!$course->is_published)
                <form action="{{ route('teacher.courses.publish', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Опубликовать курс
                    </button>
                </form>
            @else
                <form action="{{ route('teacher.courses.unpublish', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                        Снять с публикации
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
