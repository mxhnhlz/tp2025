@extends('layouts.app')

@section('title', 'Просмотр раздела')

@section('content')
    <h1>{{ $section->title }}</h1>

    <p>{{ $section->description }}</p>

    <a href="{{ route('sections.edit', $section) }}" class="btn btn-warning">Редактировать</a>
@endsection
