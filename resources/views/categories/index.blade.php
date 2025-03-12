@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-900">Категории курсов</h1>
            @auth
                @if(auth()->user()->role === 'teacher')
                    <a href="{{ route('teacher.categories.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Создать категорию
                    </a>
                @endif
            @endauth
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if($categories->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600">Категории пока не созданы.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-blue-600">
                                    {{ $category->name }}
                                </a>
                            </h2>

                            @if($category->description)
                                <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 150) }}</p>
                            @endif

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">
                                    {{ $category->courses->where('is_published', true)->count() }} курсов
                                </span>

                                @auth
                                    @if(auth()->user()->role === 'teacher')
                                        <div class="flex space-x-2">
                                            <a href="{{ route('teacher.categories.edit', $category) }}" class="text-blue-600 hover:underline">
                                                Редактировать
                                            </a>
                                            <form method="POST" action="{{ route('teacher.categories.destroy', $category) }}"
                                                  onsubmit="return confirm('Вы уверены? Это действие нельзя отменить.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
