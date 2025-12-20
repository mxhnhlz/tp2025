@extends('admin.layout')

@section('title', 'Теории')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Теории</h1>
        <a href="{{ route('admin.theories.create') }}"
           class="px-5 py-2 bg-black text-white rounded-xl shadow-lg hover:bg-gray-800 transition-all font-semibold">
            Добавить теорию
        </a>
    </div>

    <div class="space-y-4">
        @foreach($theories as $theory)
            <div class="bg-white glass p-4 rounded-2xl shadow-lg border border-white/20 hover:shadow-2xl transition-all duration-300 flex justify-between items-center">
                <div class="flex flex-col">
                    <span class="text-gray-500 font-semibold">#{{ $theory->id }}</span>
                    <span class="text-gray-800 font-medium">{{ $theory->task->title }}</span>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.theories.show', $theory) }}"
                       class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors text-sm">Просмотр</a>

                    <a href="{{ route('admin.theories.edit', $theory ) }}"
                       class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">Изменить</a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = true"
                                class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                            Удалить
                        </button>
                        <div x-show="open" @click.away="open = false"
                             class="absolute top-10 right-0 bg-white border p-4 rounded-2xl shadow-xl w-64 z-50">
                            <p class="text-gray-700 mb-2 text-sm">Вы точно хотите удалить эту теорию?</p>
                            <div class="flex justify-end gap-2">
                                <button @click="open = false"
                                        class="px-3 py-1 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">Отмена</button>
                                <form method="POST" action="{{ route('admin.theories.destroy', $theory) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
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

    @if($theories->isEmpty())
        <div class="mt-8 text-center text-gray-500">
            Теорий пока нет. Добавьте первую теорию.
        </div>
    @endif
@endsection
