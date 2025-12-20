@extends('layouts.app')

@section('title', 'Добавить теорию')

@section('content')
    <h1>Добавить теорию</h1>

    <!-- Сообщения об успехе -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Ошибки валидации -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('theories.store') }}" method="POST">
        @csrf

        <!-- Выбор задания -->
        <div class="mb-3">
            <label class="form-label">Задание</label>
            <select name="task_id" class="form-control" required>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}" {{ old('task_id') == $task->id ? 'selected' : '' }}>
                        {{ $task->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Редактор Quill -->
        <div class="mb-3">
            <label class="form-label">Содержимое теории</label>
            <div id="editor" style="height: 300px;">{!! old('content', $theory->content ?? '') !!}</div>
            <input type="hidden" name="content" id="contentInput">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('theories.index') }}" class="btn btn-secondary">Назад</a>
    </form>

    <!-- Quill CSS & JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        // Инициализация Quill
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'], // стиль текста
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }], // списки
                    ['link'] // ссылки
                ]
            }
        });

        // При сабмите формы копируем HTML в скрытое поле
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('contentInput').value = quill.root.innerHTML;
        });
    </script>
@endsection
