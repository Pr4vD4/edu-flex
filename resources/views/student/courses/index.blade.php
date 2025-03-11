@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0">Мои курсы</h1>
            <p class="text-muted">Список курсов, на которые вы записаны</p>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    @if($courses->isEmpty())
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <h3 class="h5 mb-3">У вас пока нет записанных курсов</h3>
                <p class="text-muted mb-4">Запишитесь на интересующие вас курсы, чтобы начать обучение</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary">Перейти к каталогу курсов</a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}">
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="bi bi-book" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            @php
                                $enrollment = $course->enrollments->where('user_id', auth()->id())->first();
                                $progress = $enrollment ? $enrollment->progress : 0;
                            @endphp

                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;"
                                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Прогресс: {{ $progress }}%</small>
                                <a href="{{ route('student.courses.study', $course) }}" class="btn btn-sm btn-primary">
                                    Продолжить обучение
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection