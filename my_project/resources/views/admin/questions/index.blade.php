@extends('admin.layout')
@section('title', 'Вопросы')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-800">Вопросы</h1>
            <a href="{{ route('admin.questions.create') }}"
               class="px-5 py-2 bg-black text-white rounded-xl shadow-lg hover:bg-gray-800 transition-all font-semibold">
                Добавить вопрос
            </a>
        </div>

        {{-- Фильтры и сортировка --}}
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-center">
            <select name="type" class="border rounded-lg px-3 py-2">
                <option value="">Все типы</option>
                <option value="single" {{ request('type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="multiple" {{ request('type') == 'multiple' ? 'selected' : '' }}>Multiple</option>
                <option value="text" {{ request('type') == 'text' ? 'selected' : '' }}>Text</option>
            </select>

            <select name="sort" class="border rounded-lg px-3 py-2">
                <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>Сортировка по ID</option>
                <option value="points" {{ request('sort') == 'points' ? 'selected' : '' }}>Сортировка по баллам</option>
            </select>

            @php
                $direction = request('direction', 'asc');
                $nextDirection = $direction === 'asc' ? 'desc' : 'asc';
            @endphp
            <button type="submit" name="direction" value="{{ $nextDirection }}"
                    class="px-3 py-2 border rounded-lg flex items-center gap-1 hover:bg-gray-100 transition-colors">
                @if($direction === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                @endif
            </button>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Применить
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($questions as $question)
                <div class="bg-white glass p-6 rounded-2xl shadow-lg border border-white/20 hover:shadow-2xl transition-all duration-300 flex flex-col justify-between">

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-500 font-semibold">#{{ $question->id }}</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($question->type === 'single') bg-blue-100 text-blue-800
                        @elseif($question->type === 'multiple') bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($question->type) }}
                    </span>
                        </div>

                        <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $question->content }}</h2>
                        <p class="text-gray-500 text-sm mb-1">Задание: <span class="font-medium">{{ $question->task->title }}</span></p>
                        <p class="text-gray-500 text-sm mb-4">Баллы: <span class="font-medium">{{ $question->points ?? 0 }}</span></p>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('admin.questions.show', $question) }}"
                           class="flex-1 text-center px-3 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                            Просмотр
                        </a>
                        <a href="{{ route('admin.questions.edit', $question) }}"
                           class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            Изменить
                        </a>
                        <div x-data="{ open: false }" class="flex-1 relative">
                            <button @click="open = true"
                                    class="w-full px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                                Удалить
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute top-10 left-0 bg-white border p-4 rounded-2xl shadow-xl w-full z-50">
                                <p class="text-gray-700 mb-2 text-sm">Вы точно хотите удалить этот вопрос?</p>
                                <div class="flex justify-end gap-2">
                                    <button @click="open = false"
                                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">Отмена</button>
                                    <form method="POST" action="{{ route('admin.questions.destroy', $question) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
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


        {{-- Пагинация --}}
        <div class="mt-6 flex justify-center">
            {{ $questions->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>

        @if($questions->isEmpty())
            <div class="mt-8 text-center text-gray-500">
                Вопросов пока нет. Добавьте первый вопрос.
            </div>
        @endif
    </div>
@endsection
