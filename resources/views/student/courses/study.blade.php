@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-6">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ $course->title }}</h1>
                    <div class="text-blue-100 flex items-center mt-1">
                        <a href="{{ route('student.courses') }}" class="hover:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Назад к моим курсам
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    @php
                        $enrollmentData = Auth::user()->enrollments->where('course_id', $course->id)->first();
                        $progress = $enrollmentData ? $enrollmentData->progress : 0;
                    @endphp
                    <div class="text-white text-sm mb-1 flex justify-between">
                        <span>Ваш прогресс</span>
                        <span>{{ $progress }}%</span>
                    </div>
                    <div class="w-64 bg-blue-900 bg-opacity-50 rounded-full h-2.5">
                        <div class="bg-blue-100 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Боковая панель -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-4 sticky top-20">
                    <h2 class="text-lg font-semibold mb-4">Содержание курса</h2>
                    <div class="space-y-2">
                        @if($course->lessons->count() > 0)
                            @foreach($course->lessons as $lessonItem)
                                <a href="{{ route('student.courses.study', ['course' => $course, 'lesson' => $lessonItem->id]) }}"
                                   class="flex items-center p-2 {{ request()->query('lesson') == $lessonItem->id ? 'bg-blue-50 text-blue-600 rounded' : 'text-gray-700 hover:bg-gray-50 rounded' }}">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full {{ request()->query('lesson') == $lessonItem->id ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-500' }} flex items-center justify-center mr-3 text-sm">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <span class="block text-sm">{{ $lessonItem->title }}</span>
                                        <span class="text-xs {{ request()->query('lesson') == $lessonItem->id ? 'text-blue-400' : 'text-gray-400' }}">{{ $lessonItem->duration ?? 'Урок' }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-sm">У этого курса пока нет уроков</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="w-full lg:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    @if(isset($lesson))
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold mb-4">{{ $lesson->title }}</h2>

                            @if($lesson->video_url)
                                <div class="mb-6 aspect-video">
                                    <iframe class="w-full h-full rounded-lg" src="{{ $lesson->video_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @endif

                            <div class="prose max-w-none">
                                {!! $lesson->content !!}
                            </div>

                            @if($lesson->attachments->count() > 0)
                                <div class="mt-8">
                                    <h3 class="text-lg font-semibold mb-3">Материалы к уроку</h3>
                                    <div class="space-y-2">
                                        @foreach($lesson->attachments as $attachment)
                                            <a href="{{ asset($attachment->file_path) }}" target="_blank" class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <div>
                                                    <span class="block font-medium">{{ $attachment->title }}</span>
                                                    <span class="text-xs text-gray-500">Скачать материал</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-8 flex justify-between">
                                @if($prevLesson)
                                    <a href="{{ route('student.courses.study', ['course' => $course, 'lesson' => $prevLesson->id]) }}" class="flex items-center text-gray-700 hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Предыдущий урок
                                    </a>
                                @else
                                    <div></div>
                                @endif

                                @if($nextLesson)
                                    <a href="{{ route('student.courses.study', ['course' => $course, 'lesson' => $nextLesson->id]) }}" class="flex items-center text-gray-700 hover:text-blue-600">
                                        Следующий урок
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <div></div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="text-xl font-semibold mb-2">Начните изучение курса</h3>
                            <p class="text-gray-600 mb-4">Выберите урок из содержания курса, чтобы начать обучение</p>
                            @if($course->lessons->count() > 0)
                                <a href="{{ route('student.courses.study', ['course' => $course, 'lesson' => $course->lessons->first()->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                                    Перейти к первому уроку
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Информация о курсе -->
                    <div class="mt-8 border-t pt-8">
                        <h3 class="text-lg font-semibold mb-4">О курсе</h3>
                        <div class="flex flex-wrap gap-4 mb-4">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $course->lessons->count() }} уроков</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ $course->students->count() }} студентов</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>Ваш прогресс: {{ $progress }}%</span>
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $course->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
