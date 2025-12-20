@extends('layouts.app')

@section('title', 'Список вопросов')

@section('content')
    <h1>Вопросы</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Добавить вопрос</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Задание</th>
            <th>Тип</th>
            <th>Порядок</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($questions as $question)
            <tr>
                <td>{{ $question->id }}</td>
                <td>{{ $question->task->title }}</td>
                <td>{{ $question->type }}</td>
                <td>{{ $question->order }}</td>
                <td>
                    <a href="{{ route('questions.show', $question) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('questions.edit', $question) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
