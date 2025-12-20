@extends('layouts.app')

@section('title', 'Редактировать раздел')

@section('content')
    <h1>Редактировать раздел: {{ $section->title }}</h1>

    <form action="{{ route('sections.update', $section) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $section->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="4">
                {{ old('description', $section->description) }}
            </textarea>
        </div>

        <button class="btn btn-success">Сохранить изменения</button>
        <a href="{{ route('sections.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
