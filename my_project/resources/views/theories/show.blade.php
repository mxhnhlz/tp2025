@extends('layouts.app')

@section('title', 'Просмотр теории')

@section('content')
    <h1>Теория для задания: {{ $theory->task->title }}</h1>

    <div class="card p-3 bg-light mb-3">
        {!! $theory->content !!}
    </div>

    <a href="{{ route('theories.edit', $theory) }}" class="btn btn-warning">Редактировать</a>
    <a href="{{ route('theories.index') }}" class="btn btn-secondary">Назад</a>
@endsection
