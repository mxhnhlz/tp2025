@extends('layouts.app')

@section('title', 'Просмотр вопроса')

@section('content')
    <h1>Вопрос</h1>

    <div class="card p-3 mb-3">
        <p><strong>Задание:</strong> {{ $question->task->title }}</p>
        <p><strong>Тип:</strong> {{ $question->type }}</p>
        <p><strong>Порядок:</strong> {{ $question->order }}</p>
        <p><strong>Вопрос:</strong> {{ $question->content }}</p>
        @if($question->hint)
            <p><strong>Подсказка:</strong> {{ $question->hint }}</p>
        @endif
    </div>

    <a href="{{ route('questions.edit', $question) }}" class="btn btn-warning">Редактировать</a>
    <a href="{{ route('questions.index') }}" class="btn btn-secondary">Назад</a>
@endsection
