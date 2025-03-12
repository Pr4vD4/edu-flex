@props(['course'])

<div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
        @if($course->image)
            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-r from-blue-100 to-indigo-100 flex items-center justify-center">
                <img src="{{ asset('img/icons/book.svg') }}" alt="Course" class="h-12 w-12 text-blue-400">
            </div>
        @endif

        <div class="absolute top-4 left-4">
            <span class="px-2 py-1 text-xs font-medium bg-blue-600 text-white rounded-md shadow-sm">
                {{ $course->category ? $course->category->name : 'Без категории' }}
            </span>
        </div>

        @if($course->is_featured)
            <div class="absolute top-4 right-4">
                <span class="px-2 py-1 text-xs font-medium bg-yellow-500 text-white rounded-md shadow-sm">
                    Популярный
                </span>
            </div>
        @endif
    </div>

    <div class="p-6">
        <h3 class="text-lg font-bold mb-2 line-clamp-2 min-h-[3.5rem]">{{ $course->title }}</h3>

        <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[2.5rem]">{{ $course->description }}</p>

        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 mr-3">
                <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($course->teacher ? $course->teacher->name : 'Unknown') }}&color=7F9CF5&background=EBF4FF" alt="{{ $course->teacher ? $course->teacher->name : 'Unknown' }}">
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $course->teacher ? $course->teacher->name : 'Неизвестный преподаватель' }}</p>
                <p class="text-xs text-gray-500">Преподаватель</p>
            </div>
        </div>

        <div class="flex items-center text-sm text-gray-500 mb-4">
            <div class="flex items-center mr-4">
                <img src="{{ asset('img/icons/clock.svg') }}" alt="Duration" class="h-4 w-4 mr-1 text-gray-400">
                <span>{{ $course->duration ?? '?' }} мин</span>
            </div>
            <div class="flex items-center">
                <img src="{{ asset('img/icons/users.svg') }}" alt="Students" class="h-4 w-4 mr-1 text-gray-400">
                <span>{{ $course->students_count ?? 0 }} студентов</span>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <div class="text-lg font-bold text-blue-600">
                @if($course->price > 0)
                    {{ number_format($course->price, 0, '.', ' ') }} ₽
                @else
                    Бесплатно
                @endif
            </div>

            <a href="{{ route('courses.show', $course->slug) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                Подробнее
                <img src="{{ asset('img/icons/arrow-right.svg') }}" alt="Arrow" class="h-4 w-4 ml-1">
            </a>
        </div>
    </div>
</div>
