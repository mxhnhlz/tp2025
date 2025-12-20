@extends('layouts.app')

@section('title', 'Создать раздел')

@section('content')
    <h1>Создать новый раздел</h1>

    <form action="{{ route('sections.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <button class="btn btn-primary">Создать</button>
    </form>
@endsection
