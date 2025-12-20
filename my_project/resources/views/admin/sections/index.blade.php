@extends('admin.layout')
@section('title', 'Разделы')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Разделы</h1>
            <a href="{{ route('admin.sections.create') }}"
               class="px-5 py-2 bg-black text-white rounded-2xl shadow hover:bg-gray-800 transition-all font-semibold">
                Добавить раздел
            </a>
        </div>

        <ul class="bg-white rounded-xl shadow divide-y divide-gray-200">
            @foreach($sections as $section)
                <li class="flex justify-between items-center p-4 hover:bg-gray-50 transition-colors">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $section->title }}</h2>
                        <p class="text-gray-600 text-sm mt-1">{{ $section->description ?: 'Описание отсутствует' }}</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.sections.edit', $section) }}"
                           class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                            Изменить
                        </a>

                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = true"
                                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                                Удалить
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute top-10 left-0 bg-white border p-4 rounded-2xl shadow-lg w-64 text-sm z-50">
                                <p class="mb-2">Вы точно хотите удалить этот раздел?</p>
                                <div class="flex justify-end gap-2">
                                    <button @click="open = false"
                                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">Отмена</button>
                                    <form method="POST" action="{{ route('admin.sections.destroy', $section) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('admin.sections.show', $section) }}"
                           class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                            Просмотр
                        </a>

                        <a href="{{ route('admin.sections.preview', $section) }}"
                           class="px-3 py-1 bg-green-400 text-white rounded-lg hover:bg-green-500 transition-colors text-sm">
                            Превью
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
