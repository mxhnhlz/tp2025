@extends('admin.layout')
@section('title', 'Редактировать задание')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Редактировать задание</h1>

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
            <form action="{{ route('admin.tasks.update', $task) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Название и slug --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Название задания</label>
                        <input type="text" name="title" value="{{ old('title', $task->title) }}" required
                               class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Ссылка (slug)</label>
                        <input type="text" name="slug" value="{{ old('slug', $task->slug) }}" required
                               class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">
                    </div>
                </div>

                {{-- Раздел --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Раздел</label>
                    <select name="section_id" required
                            class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id', $task->section_id) == $section->id ? 'selected' : '' }}>
                                {{ $section->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Описание --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Описание</label>
                    <textarea name="description" rows="5"
                              class="w-full border rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">{{ old('description', $task->description) }}</textarea>
                </div>

                {{-- Сложность, баллы, порядок --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Сложность</label>
                        <select name="difficulty" required
                                class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">
                            <option value="easy" {{ old('difficulty', $task->difficulty)=='easy' ? 'selected' : '' }}>Easy</option>
                            <option value="medium" {{ old('difficulty', $task->difficulty)=='medium' ? 'selected' : '' }}>Medium</option>
                            <option value="hard" {{ old('difficulty', $task->difficulty)=='hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Баллы</label>
                        <input type="number" name="points" value="{{ old('points', $task->points) }}"
                               class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold text-gray-700">Порядок</label>
                        <input type="number" name="order" value="{{ old('order', $task->order) }}"
                               class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all">
                    </div>
                </div>

                {{-- Кнопки --}}
                <div class="flex gap-4 mt-4">
                    <button type="submit"
                            class="px-6 py-3 bg-green-600 text-white rounded-2xl shadow hover:bg-green-700 transition-all font-semibold">
                        Сохранить
                    </button>
                    <a href="{{ route('admin.tasks.index') }}"
                       class="px-6 py-3 bg-gray-200 text-gray-800 rounded-2xl shadow hover:bg-gray-300 transition-all font-semibold">
                        Назад
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
