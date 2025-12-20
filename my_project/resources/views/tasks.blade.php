@extends('layouts.app')

@section('title', 'Задания - CyberSafe Trainer')

@section('content')
    @include('partials.header')

    <!-- Tasks Page Hero -->
    <section class="hero tasks-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Выберите <span class="gradient-text">задание</span></h1>
                <p>Задания сгруппированы по разделам. Выберите уровень сложности и прокачивайте навыки по кибербезопасности.</p>
            </div>
        </div>
    </section>

    <!-- Tasks List -->
    <section class="tasks-list">
        <div class="container">
            <div class="section-header">
                <h2>Все <span class="gradient-text">задания</span></h2>
                <p>Пройдите практические задания, чтобы улучшить свои навыки</p>
            </div>

            <div class="tasks-grid">
                @foreach($sections as $section)
                    <div class="task-section">
                        <h3>{{ $section->title }}</h3>
                        <div class="task-cards">
                            @foreach($section->tasks as $task)
                                <a href="{{ route('tasks.show', $task->id) }}" class="task-card">
                                    <div class="task-header">
                                        <span class="task-level">Уровень: {{ $task->level }}</span>
                                    </div>
                                    <h4>{{ $task->title }}</h4>
                                    <p>{{ Str::limit($task->description, 80) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
