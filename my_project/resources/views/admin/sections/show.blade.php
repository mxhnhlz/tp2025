@extends('admin.layout')
@section('title', 'Просмотр раздела')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">{{ $section->title }}</h1>

    <div class="bg-white p-6 rounded-xl shadow max-w-2xl">
        <p class="whitespace-pre-line">{{ $section->description }}</p>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('admin.sections.edit', $section) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                Редактировать
            </a>
            <a href="{{ route('admin.sections.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Назад
            </a>
        </div>
    </div>
@endsection
