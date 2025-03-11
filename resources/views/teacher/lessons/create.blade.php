@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Добавление нового урока</h1>
                <p class="text-gray-600 mt-1">Курс: {{ $course->title }}</p>
            </div>
            <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                Назад к урокам
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.courses.lessons.store', $course) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg overflow-hidden">
            @csrf
            <div class="p-6">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название урока *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Краткое описание</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Краткое описание, которое будет отображаться в списке уроков</p>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Содержание урока *</label>
                    <textarea name="content" id="content" rows="15" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('content') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Вы можете использовать HTML-форматирование для улучшения отображения содержания</p>
                </div>

                <div class="mb-4">
                    <label for="duration_minutes" class="block text-gray-700 text-sm font-bold mb-2">Длительность (в минутах)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" min="1" value="{{ old('duration_minutes') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Приблизительное время, необходимое для изучения урока</p>
                </div>

                <div class="mb-4">
                    <label for="position" class="block text-gray-700 text-sm font-bold mb-2">Позиция в курсе</label>
                    <input type="number" name="position" id="position" min="1" value="{{ old('position', $course->lessons->count() + 1) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Порядковый номер урока в курсе</p>
                </div>

                <div class="mb-4">
                    <label for="attachments" class="block text-gray-700 text-sm font-bold mb-2">Прикрепленные файлы</label>
                    <input type="file" name="attachments[]" id="attachments" multiple class="w-full py-2">
                    <p class="text-sm text-gray-500 mt-1">Вы можете прикрепить несколько файлов (PDF, DOCX, ZIP и т.д.). Максимальный размер каждого файла: 10MB</p>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" class="mr-2" {{ old('is_published') ? 'checked' : '' }}>
                        <span class="text-gray-700">Опубликовать урок</span>
                    </label>
                    <p class="text-sm text-gray-500 mt-1">Опубликованные уроки видны студентам курса</p>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-gray-600 hover:text-gray-900">
                        Отмена
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Создать урок
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
