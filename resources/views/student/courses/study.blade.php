@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Боковая панель с уроками -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $course->title }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($course->lessons as $lessonItem)
                            <a href="{{ route('student.courses.study', ['course' => $course->id, 'lesson' => $lessonItem->id]) }}"
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                                      {{ isset($lesson) && $lesson->id == $lessonItem->id ? 'active' : '' }}">
                                <div>
                                    <i class="bi bi-play-circle me-2"></i>
                                    {{ $lessonItem->title }}
                                </div>
                                <span class="badge bg-secondary rounded-pill">{{ $lessonItem->duration_minutes }} мин</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('student.courses') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Назад к моим курсам
                </a>
            </div>
        </div>

        <!-- Основной контент урока -->
        <div class="col-md-9">
            @if(isset($lesson))
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $lesson->title }}</h4>
                        <span class="badge bg-primary">{{ $lesson->duration_minutes }} минут</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            {!! $lesson->content !!}
                        </div>

                        @if($lesson->attachments->count() > 0)
                            <div class="mt-4">
                                <h5>Прикрепленные материалы:</h5>
                                <div class="list-group">
                                    @foreach($lesson->attachments as $attachment)
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}"
                                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                           target="_blank">
                                            <div>
                                                <i class="bi bi-file-earmark me-2"></i>
                                                {{ $attachment->title }}
                                            </div>
                                            <span class="badge bg-light text-dark">
                                                {{ number_format($attachment->file_size / 1024, 2) }} KB
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        @php
                            $currentIndex = $course->lessons->search(function($item) use ($lesson) {
                                return $item->id === $lesson->id;
                            });
                            $prevLesson = $currentIndex > 0 ? $course->lessons[$currentIndex - 1] : null;
                            $nextLesson = $currentIndex < $course->lessons->count() - 1 ? $course->lessons[$currentIndex + 1] : null;
                        @endphp

                        <div>
                            @if($prevLesson)
                                <a href="{{ route('student.courses.study', ['course' => $course->id, 'lesson' => $prevLesson->id]) }}"
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i>Предыдущий урок
                                </a>
                            @endif
                        </div>

                        <div>
                            @if($nextLesson)
                                <a href="{{ route('student.courses.study', ['course' => $course->id, 'lesson' => $nextLesson->id]) }}"
                                   class="btn btn-primary">
                                    Следующий урок<i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            @else
                                <form action="{{ route('student.courses.complete', $course) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle me-2"></i>Завершить курс
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <h3 class="h4 mb-3">Добро пожаловать на курс "{{ $course->title }}"</h3>
                        <p class="text-muted mb-4">Выберите урок из списка слева, чтобы начать обучение</p>
                        @if($course->lessons->isNotEmpty())
                            <a href="{{ route('student.courses.study', ['course' => $course->id, 'lesson' => $course->lessons->first()->id]) }}"
                               class="btn btn-primary">
                                Начать с первого урока
                            </a>
                        @else
                            <div class="alert alert-warning">
                                В этом курсе пока нет уроков. Пожалуйста, свяжитесь с преподавателем.
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
