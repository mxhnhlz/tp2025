@extends('admin.layout')
@section('title', $task->title)

@section('content')
    <h1 class="text-2xl font-semibold mb-4">{{ $task->title }}</h1>

    <div class="bg-white p-6 rounded-xl shadow max-w-3xl space-y-3">
        <p><strong>Раздел:</strong> {{ $task->section->title }}</p>
        <p><strong>Описание:</strong> {{ $task->description }}</p>
        <p><strong>Сложность:</strong>
            @if($task->difficulty == 'easy')
                <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">{{ ucfirst($task->difficulty) }}</span>
            @elseif($task->difficulty == 'medium')
                <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs">{{ ucfirst($task->difficulty) }}</span>
            @else
                <span class="px-2 py-1 bg-red-200 text-red-800 rounded-full text-xs">{{ ucfirst($task->difficulty) }}</span>
            @endif
        </p>
        <p><strong>Баллы:</strong> {{ $task->points }}</p>
        <p><strong>Порядок:</strong> {{ $task->order }}</p>

        <div class="flex gap-3 mt-4">
            <a href="{{ route('admin.tasks.edit', $task) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                Редактировать
            </a>
            <a href="{{ route('admin.tasks.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                Назад
            </a>
        </div>
    </div>
@endsection
