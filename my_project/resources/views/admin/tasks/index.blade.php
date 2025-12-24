@extends('admin.layout')
@section('title', 'Задания')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Задания</h1>
        <a href="{{ route('admin.tasks.create') }}"
           class="px-5 py-2 bg-black text-white rounded-xl shadow hover:bg-gray-800 transition-all font-semibold">
            Создать задание
        </a>
    </div>

    <div class="space-y-4">
        @foreach($tasks as $task)
            <div class="bg-white p-5 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $task->title }}</h2>
                    <p class="text-gray-600">Раздел: <strong>{{ $task->section->title }}</strong></p>
                    <div class="flex items-center gap-2 mt-1">
                <span class="px-2 py-1 rounded-full text-xs
                    @if($task->difficulty == 'easy') bg-green-200 text-green-800
                    @elseif($task->difficulty == 'medium') bg-yellow-200 text-yellow-800
                    @else bg-red-200 text-red-800 @endif">
                    {{ ucfirst($task->difficulty) }}
                </span>
                        <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-xs">
    Баллы: {{ $task->total_points }}
</span>

                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.tasks.show', $task) }}"
                       class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors text-sm">Просмотр</a>
                    <a href="{{ route('admin.tasks.edit', $task) }}"
                       class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">Изменить</a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = true"
                                class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                            Удалить
                        </button>
                        <div x-show="open" @click.away="open = false"
                             class="absolute top-10 right-0 bg-white border p-4 rounded shadow-lg w-64 text-sm z-50">
                            <p class="mb-2">Вы точно хотите удалить это задание?</p>
                            <div class="flex justify-end gap-2">
                                <button @click="open = false"
                                        class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Отмена</button>
                                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
