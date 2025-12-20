@extends('layouts.app')

@section('title', 'Теории')

@section('content')
    <h1>Теории</h1>
    <a href="{{ route('theories.create') }}" class="btn btn-primary mb-3">Добавить теорию</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Задание</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($theories as $theory)
            <tr>
                <td>{{ $theory->id }}</td>
                <td>{{ $theory->task->title }}</td>
                <td>
                    <a href="{{ route('theories.show', $theory) }}" class="btn btn-info btn-sm">Просмотр</a>
                    <a href="{{ route('theories.edit', $theory) }}" class="btn btn-warning btn-sm">Редактировать</a>
                    <form action="{{ route('theories.destroy', $theory) }}" method="POST" class="d-inline">
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

