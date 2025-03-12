@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Редактирование курса</h1>
                <p class="text-gray-600 mt-1">{{ $course->title }}</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Управление уроками
                </a>
                <a href="{{ route('teacher.courses.index') }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Назад к курсам
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
            <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название курса *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание курса *</label>
                        <textarea name="description" id="description" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $course->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Текущее изображение</label>
                        @if ($course->image)
                            <div class="mb-2">
                                <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="max-w-xs rounded">
                            </div>
                        @else
                            <p class="text-gray-500">Изображение не загружено</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Изменить изображение</label>
                        <input type="file" name="image" id="image" class="w-full py-2">
                        <p class="text-sm text-gray-500 mt-1">Оставьте пустым, чтобы сохранить текущее изображение</p>
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Цена курса (руб.)</label>
                        <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price', $course->price) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Оставьте 0 для бесплатного курса</p>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Категория</label>
                        <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $course->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Выберите категорию для курса</p>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Статус курса</label>
                        <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="draft" {{ (old('status', $course->status) == 'draft') ? 'selected' : '' }}>Черновик</option>
                            <option value="published" {{ (old('status', $course->status) == 'published') ? 'selected' : '' }}>Опубликован</option>
                            <option value="archived" {{ (old('status', $course->status) == 'archived') ? 'selected' : '' }}>В архиве</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Опубликованные курсы видны всем пользователям, курсы в архиве скрыты</p>
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
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Статистика курса</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900">Студенты</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $course->students->count() }}</p>
                        <a href="{{ route('teacher.courses.students', $course) }}" class="text-blue-600 hover:underline text-sm">Посмотреть студентов</a>
                    </div>
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900">Уроки</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $course->lessons->count() }}</p>
                        <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="text-blue-600 hover:underline text-sm">Управление уроками</a>
                    </div>
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900">Статус</h3>
                        <p class="text-xl font-bold
                            {{ $course->status === 'published' ? 'text-green-600' :
                              ($course->status === 'archived' ? 'text-gray-600' : 'text-yellow-600') }}">
                            {{ $course->status === 'published' ? 'Опубликован' :
                              ($course->status === 'archived' ? 'В архиве' : 'Черновик') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
