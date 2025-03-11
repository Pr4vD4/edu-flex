@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold text-gray-900">{{ $lesson->title }}</h1>
                    @if(!$lesson->is_published)
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Черновик
                        </span>
                    @endif
                </div>
                <p class="text-gray-600 mt-1">
                    Курс: <a href="{{ route('teacher.courses.show', $course) }}" class="text-blue-600 hover:underline">{{ $course->title }}</a>
                </p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('teacher.courses.lessons.edit', [$course, $lesson]) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Редактировать урок
                </a>
                <a href="{{ route('teacher.courses.lessons.index', $course) }}" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    К списку уроков
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Позиция</div>
                        <div class="mt-1">{{ $lesson->position }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Длительность</div>
                        <div class="mt-1">{{ $lesson->duration_minutes ?? 'Не указана' }} мин.</div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Дата создания</div>
                        <div class="mt-1">{{ $lesson->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500">Последнее обновление</div>
                        <div class="mt-1">{{ $lesson->updated_at->format('d.m.Y H:i') }}</div>
                    </div>
                </div>

                @if($lesson->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Краткое описание</h3>
                        <div class="text-gray-700 bg-gray-50 p-4 rounded-md">
                            {{ $lesson->description }}
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Содержание урока</h3>
                    <div class="lesson-content bg-gray-50 p-4 rounded-md text-gray-700">
                        {!! $lesson->content !!}
                    </div>
                </div>

                @if($lesson->attachments && $lesson->attachments->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Прикрепленные файлы</h3>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="space-y-2">
                                @foreach($lesson->attachments as $attachment)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <div>
                                            <p class="font-medium">{{ $attachment->title }}</p>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <span>{{ $attachment->file_type }}</span>
                                                <span class="ml-2">{{ number_format($attachment->file_size / 1024, 1) }} KB</span>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                Скачать
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-8 flex justify-between">
            @if($prevLesson)
                <a href="{{ route('teacher.courses.lessons.show', [$course, $prevLesson]) }}" class="flex items-center text-gray-700 hover:text-blue-600">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Предыдущий урок: {{ Str::limit($prevLesson->title, 50) }}
                </a>
            @else
                <div></div>
            @endif

            @if($nextLesson)
                <a href="{{ route('teacher.courses.lessons.show', [$course, $nextLesson]) }}" class="flex items-center text-gray-700 hover:text-blue-600">
                    {{ Str::limit($nextLesson->title, 50) }}: Следующий урок
                    <svg class="h-5 w-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <div></div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .lesson-content h1 {
        font-size: 1.5rem;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    .lesson-content h2 {
        font-size: 1.25rem;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    .lesson-content h3 {
        font-size: 1.125rem;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .lesson-content p {
        margin-bottom: 0.75rem;
    }
    .lesson-content ul, .lesson-content ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .lesson-content ul {
        list-style-type: disc;
    }
    .lesson-content ol {
        list-style-type: decimal;
    }
    .lesson-content pre {
        background-color: #f1f5f9;
        padding: 1rem;
        border-radius: 0.375rem;
        overflow-x: auto;
        margin-bottom: 1rem;
    }
    .lesson-content code {
        font-family: monospace;
        background-color: #f1f5f9;
        padding: 0.125rem 0.25rem;
        border-radius: 0.25rem;
    }
    .lesson-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
        border-radius: 0.375rem;
    }
    .lesson-content blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1rem;
        font-style: italic;
        margin: 1rem 0;
    }
    .lesson-content a {
        color: #2563eb;
        text-decoration: underline;
    }
    .lesson-content a:hover {
        color: #1d4ed8;
    }
    .lesson-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .lesson-content th, .lesson-content td {
        border: 1px solid #e5e7eb;
        padding: 0.5rem;
    }
    .lesson-content th {
        background-color: #f1f5f9;
    }
</style>
@endpush
@endsection
