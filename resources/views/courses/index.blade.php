@extends('layouts.app')

@section('title', 'Каталог курсов')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-white mb-2">Каталог курсов</h1>
        <p class="text-blue-100 text-lg max-w-2xl">Выберите из широкого ассортимента курсов и начните свой путь к новым знаниям и навыкам.</p>
    </div>
</div>

<div class="container mx-auto px-4 py-8" x-data="{ categoryFilter: '' }">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Фильтры -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-24">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Фильтры</h3>

                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-2">Категории</h4>
                    <div class="space-y-2">
                        <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                            <input type="radio" name="category" value="" class="mr-2" x-model="categoryFilter" checked>
                            <span>Все категории</span>
                        </label>

                        @foreach($categories as $category)
                            <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                                <input type="radio" name="category" value="{{ $category->id }}" class="mr-2" x-model="categoryFilter">
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium text-gray-700 mb-2">Уровень</h4>
                    <div class="space-y-2">
                        <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                            <input type="checkbox" class="mr-2">
                            <span>Начинающий</span>
                        </label>
                        <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                            <input type="checkbox" class="mr-2">
                            <span>Средний</span>
                        </label>
                        <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                            <input type="checkbox" class="mr-2">
                            <span>Продвинутый</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-700 mb-2">Цена</h4>
                    <div class="space-y-2">
                        <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                            <input type="checkbox" class="mr-2">
                            <span>Бесплатные</span>
                        </label>
                        <label class="flex items-center text-gray-600 hover:text-blue-600 cursor-pointer">
                            <input type="checkbox" class="mr-2">
                            <span>Платные</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Список курсов -->
        <div class="w-full md:w-3/4">
            <!-- Поиск и сортировка -->
            <div class="bg-white rounded-xl shadow-md p-4 mb-6 flex flex-wrap justify-between items-center">
                <div class="w-full md:w-1/2 mb-4 md:mb-0">
                    <div class="relative">
                        <input type="text" placeholder="Поиск курсов..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="w-full md:w-auto flex items-center">
                    <span class="text-gray-600 mr-2">Сортировать:</span>
                    <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="newest">Новые</option>
                        <option value="popular">Популярные</option>
                        <option value="price_low">Цена (низкая-высокая)</option>
                        <option value="price_high">Цена (высокая-низкая)</option>
                    </select>
                </div>
            </div>

            <div>
                <p class="text-gray-600 mb-6">Найдено <span class="font-semibold">{{ $courses->count() }}</span> курсов</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data>
                    @foreach($courses as $course)
                        <div x-show="categoryFilter === '' || categoryFilter === '{{ $course->category_id }}'">
                            <x-course-card :course="$course" />
                        </div>
                    @endforeach
                </div>

                @if($courses->isEmpty())
                    <div class="bg-white rounded-lg shadow p-8 text-center">
                        <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Курсы не найдены</h3>
                        <p class="text-gray-600">Попробуйте изменить параметры поиска или фильтры.</p>
                    </div>
                @endif

                <!-- Пагинация -->
                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
