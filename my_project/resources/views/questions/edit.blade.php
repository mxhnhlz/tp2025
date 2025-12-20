@extends('layouts.app')

@section('title', 'Редактировать вопрос')

@section('content')
    <h1>Редактировать вопрос</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.update', $question) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Выбор задания -->
        <div class="mb-3">
            <label class="form-label">Задание</label>
            <select name="task_id" class="form-control" required>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}" {{ old('task_id', $question->task_id) == $task->id ? 'selected' : '' }}>
                        {{ $task->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Текст вопроса -->
        <div class="mb-3">
            <label class="form-label">Вопрос</label>
            <textarea name="content" class="form-control" required>{{ old('content', $question->content) }}</textarea>
        </div>

        <!-- Тип вопроса -->
        <div class="mb-3">
            <label class="form-label">Тип вопроса</label>
            <select name="type" class="form-control" required>
                <option value="single_choice" {{ old('type', $question->type) == 'single_choice' ? 'selected' : '' }}>Один правильный ответ</option>
                <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>Несколько правильных ответов</option>
                <option value="text" {{ old('type', $question->type) == 'text' ? 'selected' : '' }}>Текстовый ответ</option>
            </select>
        </div>

        <!-- Подсказка -->
        <div class="mb-3">
            <label class="form-label">Подсказка (необязательно)</label>
            <input type="text" name="hint" class="form-control" value="{{ old('hint', $question->hint) }}">
        </div>

        <!-- Порядок -->
        <div class="mb-3">
            <label class="form-label">Порядок отображения</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $question->order) }}" min="1" required>
        </div>

        <button type="submit" class="btn btn-success">Сохранить изменения</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
