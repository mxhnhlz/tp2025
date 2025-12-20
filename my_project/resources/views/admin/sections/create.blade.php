@extends('admin.layout')
@section('title', 'Создать раздел')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Создать раздел</h1>

    <div class="bg-white p-6 rounded-xl shadow max-w-2xl">
        <form action="{{ route('admin.sections.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-medium">Название</label>
                <input type="text" name="title" required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Описание</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                    Создать
                </button>
                <a href="{{ route('admin.sections.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Назад
                </a>
            </div>
        </form>
    </div>
@endsection
