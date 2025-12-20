@extends('admin.layout')
@section('title', 'Редактировать раздел')

@section('content')
    <h1 class="text-2xl font-semibold mb-6">Редактировать раздел</h1>

    <div class="bg-white p-6 rounded-xl shadow max-w-2xl">
        <form action="{{ route('admin.sections.update', $section) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-medium">Название</label>
                <input type="text" name="title" required
                       value="{{ old('title', $section->title) }}"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Описание</label>
                <textarea name="description" rows="4"
                          class="w-full border rounded-lg px-3 py-2">{{ old('description', $section->description) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Сохранить
                </button>
                <a href="{{ route('admin.sections.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
                    Назад
                </a>
            </div>
        </form>
    </div>
@endsection
