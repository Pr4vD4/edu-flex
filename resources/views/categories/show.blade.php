@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $category->name }}</h1>
                    <p class="text-gray-600 mt-1">Курсы в категории</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        Все категории
                    </a>

                    @auth
                        @if(auth()->user()->role === 'teacher')
                            <a href="{{ route('teacher.categories.edit', $category) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Редактировать категорию
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            @if($category->description)
                <div class="mt-4 bg-white p-4 rounded shadow">
                    <p>{{ $category->description }}</p>
                </div>
            @endif
        </div>

        @if($courses->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-600">В этой категории пока нет опубликованных курсов.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="relative">
                            @if($course->image)
                                <img src="{{ asset($course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">Нет изображения</span>
                                </div>
                            @endif

                            @if($course->price > 0)
                                <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 rounded-md text-sm">
                                    {{ $course->price }} руб.
                                </div>
                            @else
                                <div class="absolute top-2 right-2 bg-green-600 text-white px-2 py-1 rounded-md text-sm">
                                    Бесплатно
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                <a href="{{ route('courses.show', $course->slug) }}" class="hover:text-blue-600">
                                    {{ $course->title }}
                                </a>
                            </h2>

                            <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 100) }}</p>

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">
                                    {{ $course->lessons->count() }} уроков
                                </span>

                                <a href="{{ route('courses.show', $course->slug) }}" class="text-blue-600 hover:underline">
                                    Подробнее
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
