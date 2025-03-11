@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Уроки курса</h1>
                <p class="text-gray-600 mt-1">{{ $course->title }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('teacher.courses.lessons.create', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Добавить урок
                </a>
                <a href="{{ route('teacher.courses.edit', $course) }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Назад к курсу
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if ($lessons->isEmpty())
                <div class="p-6 text-center">
                    <p class="text-gray-600 mb-4">У данного курса пока нет уроков.</p>
                    <a href="{{ route('teacher.courses.lessons.create', $course) }}" class="text-blue-600 hover:underline">
                        Добавить первый урок
                    </a>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">№</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Длительность</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($lessons as $lesson)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="flex items-center">
                                        <span class="mr-4">{{ $lesson->position }}</span>
                                        <div class="flex flex-col space-y-1">
                                            <form action="{{ route('teacher.courses.lessons.move', [$course, $lesson]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="direction" value="up">
                                                <button type="submit" class="text-gray-500 hover:text-gray-700" {{ $lesson->position <= 1 ? 'disabled' : '' }}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('teacher.courses.lessons.move', [$course, $lesson]) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="direction" value="down">
                                                <button type="submit" class="text-gray-500 hover:text-gray-700" {{ $loop->last ? 'disabled' : '' }}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        <div class="font-medium">{{ $lesson->title }}</div>
                                        @if ($lesson->description)
                                            <div class="text-gray-500 text-xs mt-1">{{ Str::limit($lesson->description, 50) }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $lesson->duration_minutes ? $lesson->duration_minutes . ' мин.' : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $lesson->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $lesson->is_published ? 'Опубликован' : 'Черновик' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('teacher.courses.lessons.edit', [$course, $lesson]) }}" class="text-blue-600 hover:text-blue-900">
                                            Редактировать
                                        </a>
                                        <form action="{{ route('teacher.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот урок?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
