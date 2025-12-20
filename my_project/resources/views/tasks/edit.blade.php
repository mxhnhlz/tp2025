@extends('layouts.app')

@section('title', 'Редактировать задание')

@section('content')
    <h1>Редактировать задание: {{ $task->title }}</h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Название задания</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ссылка (slug)</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $task->slug) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Раздел</label>
            <select name="section_id" class="form-control" required>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" {{ old('section_id', $task->section_id) == $section->id ? 'selected' : '' }}>
                        {{ $section->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Сложность</label>
            <select name="difficulty" class="form-control" required>
                <option value="easy" {{ old('difficulty', $task->difficulty)=='easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ old('difficulty', $task->difficulty)=='medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ old('difficulty', $task->difficulty)=='hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Баллы</label>
            <input type="number" name="points" class="form-control" value="{{ old('points', $task->points) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Порядок</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', $task->order) }}">
        </div>

        <button class="btn btn-success">Сохранить изменения</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
