@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Создание нового курса</h1>
            <p class="text-gray-600 mt-1">Заполните форму ниже, чтобы создать новый курс</p>
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

        <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg overflow-hidden">
            @csrf
            <div class="p-6">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Название курса *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание курса *</label>
                    <textarea name="description" id="description" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Изображение курса</label>
                    <input type="file" name="image" id="image" class="w-full py-2">
                    <p class="text-sm text-gray-500 mt-1">Рекомендуемый размер: 1280x720px, формат: JPG, PNG, GIF. Максимальный размер: 2MB</p>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Цена курса (руб.)</label>
                    <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price', 0) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Оставьте 0 для бесплатного курса</p>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Категория</label>
                    <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-sm text-gray-500 mt-1">Выберите категорию для курса</p>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('teacher.courses.index') }}" class="text-gray-600 hover:text-gray-900">
                        Отмена
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Создать курс
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
