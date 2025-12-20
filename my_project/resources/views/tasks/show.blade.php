@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <h1>{{ $task->title }}</h1>

    <p><strong>Раздел:</strong> {{ $task->section->title }}</p>
    <p><strong>Описание:</strong> {{ $task->description }}</p>
    <p><strong>Сложность:</strong> {{ ucfirst($task->difficulty) }}</p>
    <p><strong>Баллы:</strong> {{ $task->points }}</p>

    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Редактировать</a>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Назад</a>
@endsection
