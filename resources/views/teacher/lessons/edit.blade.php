@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Редактирование урока</h1>
                <p class="text-gray-600 mt-1">{{ $lesson->title }} | Курс: {{ $course->title }}</p>
            </div>
            <div class="flex space-x-4">
                <form action="{{ route('teacher.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот урок?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Удалить урок
                    </button>
                </form>
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Назад к урокам
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <form action="{{ route('teacher.courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название урока *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Краткое описание</label>
                        <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $lesson->description) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Краткое описание, которое будет отображаться в списке уроков</p>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Содержание урока *</label>
                        <textarea name="content" id="content" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('content', $lesson->content) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Вы можете использовать HTML-форматирование для улучшения отображения содержания</p>
                    </div>

                    <div class="mb-4">
                        <label for="duration_minutes" class="block text-gray-700 text-sm font-bold mb-2">Длительность (в минутах)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" min="1" value="{{ old('duration_minutes', $lesson->duration_minutes) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Приблизительное время, необходимое для изучения урока</p>
                    </div>

                    <div class="mb-4">
                        <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Позиция в курсе</label>
                        <input type="number" name="position" id="position" min="1" value="{{ old('position', $lesson->position) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Порядковый номер урока в курсе</p>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" class="mr-2" {{ $lesson->is_published || old('is_published') ? 'checked' : '' }}>
                            <span class="text-gray-700">Опубликовать урок</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Опубликованные уроки видны студентам курса</p>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Сохранить изменения
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Прикрепленные файлы</h2>

                @if ($lesson->attachments->isEmpty())
                    <p class="text-gray-600">К этому уроку пока не прикреплено файлов.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($lesson->attachments as $attachment)
                            <div class="flex justify-between items-center border-b pb-4">
                                <div>
                                    <p class="font-medium">{{ $attachment->title }}</p>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span>{{ $attachment->file_type }}</span>
                                        <span class="ml-2">{{ number_format($attachment->file_size / 1024, 1) }} KB</span>
                                    </div>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        Просмотр
                                    </a>
                                    <form action="{{ route('teacher.courses.lessons.attachments.destroy', [$course, $lesson, $attachment]) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот файл?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Добавить новые файлы</h3>
                    <form action="{{ route('teacher.courses.lessons.update', [$course, $lesson]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="title" value="{{ $lesson->title }}">
                        <input type="hidden" name="content" value="{{ $lesson->content }}">
                        <input type="hidden" name="is_published" value="{{ $lesson->is_published ? 1 : 0 }}">

                        <div class="mb-4">
                            <input type="file" name="attachments[]" multiple class="w-full py-2">
                            <p class="text-sm text-gray-500 mt-1">Вы можете прикрепить несколько файлов (PDF, DOCX, ZIP и т.д.). Максимальный размер каждого файла: 10MB</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Загрузить файлы
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
