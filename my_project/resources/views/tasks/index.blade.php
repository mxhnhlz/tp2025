@extends('layouts.app')

@section('title', 'Список заданий')

@section('content')
    <h1 class="mb-4">Задания</h1>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Создать новое задание</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Раздел</th>
            <th>Сложность</th>
            <th>Баллы</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->section->title }}</td>
                <td>{{ ucfirst($task->difficulty) }}</td>
                <td>{{ $task->points }}</td>
                <td>
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Редактировать</a>

                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
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
