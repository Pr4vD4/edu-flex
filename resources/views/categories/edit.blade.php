@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Редактирование категории</h1>
            <div class="flex space-x-2">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Назад к категориям
                </a>
                <a href="{{ route('categories.show', $category->slug) }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Просмотр категории
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form action="{{ route('teacher.categories.update', $category) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Название категории*</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $category->name) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-300"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Описание</label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring focus:border-blue-300"
                    >{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Информация</label>
                    <div class="bg-gray-50 p-4 rounded border">
                        <p><span class="font-semibold">Слаг:</span> {{ $category->slug }}</p>
                        <p><span class="font-semibold">Курсов в категории:</span> {{ $category->courses->count() }}</p>
                        <p><span class="font-semibold">Дата создания:</span> {{ $category->created_at->format('d.m.Y H:i') }}</p>
                        <p><span class="font-semibold">Последнее обновление:</span> {{ $category->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <form action="{{ route('teacher.categories.destroy', $category) }}" method="POST"
                          onsubmit="return confirm('Вы уверены? Это действие нельзя отменить.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Удалить категорию
                        </button>
                    </form>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
