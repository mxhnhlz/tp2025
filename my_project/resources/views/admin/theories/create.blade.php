@extends('admin.layout')

@section('title', $theory ? 'Редактировать теорию' : 'Создать теорию')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $theory ? 'Редактирование теории' : 'Создание теории' }}</h1>
        <a href="{{ route('admin.theories.index') }}"
           class="px-5 py-2 bg-gray-200 text-gray-800 rounded-xl shadow hover:bg-gray-300 transition-all font-semibold">
            Назад
        </a>
    </div>

    <form action="{{ $theory ? route('admin.theories.update', $theory) : route('admin.theories.store') }}" method="POST">
        @csrf
        @if($theory)
            @method('PATCH')
        @endif

        <div class="bg-white glass p-6 rounded-2xl shadow-lg border border-white/20 space-y-6">
            {{-- Привязка к заданию --}}
            <div>
                <label class="block font-semibold mb-1">К заданию

                    @section('title', $theory ? 'Редактировать теорию' : 'Создать теорию')

                    @section('content')
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-3xl font-bold text-gray-800">{{ $theory ? 'Редактирование теории' : 'Создание теории' }}</h1>
                            <a href="{{ route('admin.theories.index') }}"
                               class="px-5 py-2 bg-gray-200 text-gray-800 rounded-xl shadow hover:bg-gray-300 transition-all font-semibold">
                                Назад
                            </a>
                        </div>

                        <form id="theory-form" action="{{ $theory ? route('admin.theories.update', $theory) : route('admin.theories.store') }}" method="POST">
                            @csrf
                            @if($theory)
                                @method('PUT')
                            @endif

                            <div class="bg-white glass p-6 rounded-2xl shadow-lg border border-white/20 space-y-6">
                                {{-- Привязка к заданию --}}
                                <div>
                                    <label class="block font-semibold mb-1">К заданию</label>
                                    <select name="task_id" class="w-full border rounded p-2" required>
                                        @foreach($tasks as $task)
                                            <option value="{{ $task->id }}" {{ $theory && $task->id == $theory->task_id ? 'selected' : '' }}>
                                                {{ $task->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Контент теории --}}
                                <div>
                                    <label class="block font-semibold mb-1">Содержимое теории</label>
                                    <div id="editor-container" class="border rounded h-96 bg-white">
                                        {!! $theory ? $theory->content : '' !!}
                                    </div>
                                    <input type="hidden" name="content" id="content">
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="submit"
                                            class="px-6 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition-all font-semibold">
                                        {{ $theory ? 'Сохранить' : 'Создать' }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Quill --}}
                        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
                        <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const quill = new Quill('#editor-container', {
                                    theme: 'snow',
                                    placeholder: 'Введите текст теории...',
                                    modules: {
                                        toolbar: [
                                            [{ 'header': [1, 2, 3, false] }],
                                            ['bold', 'italic', 'underline', 'strike'],
                                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                            ['link', 'image', 'code-block'],
                                            [{ 'color': [] }, { 'background': [] }],
                                            ['clean']
                                        ]
                                    }
                                });

                                const form = document.getElementById('theory-form');
                                form.onsubmit = function() {
                                    // Копируем содержимое Quill в скрытый input
                                    const contentInput = document.getElementById('content');
                                    contentInput.value = quill.root.innerHTML;
                                };
                            });
                        </script>
                    @endsection

                    <select name="task_id" class="w-full border rounded p-2" required>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" {{ $theory && $task->id == $theory->task_id ? 'selected' : '' }}>
                            {{ $task->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Контент теории --}}
            <div>
                <label class="block font-semibold mb-1">Содержимое теории</label>
                <div id="editor-container" class="border rounded h-96 bg-white">
                    {!! $theory ? $theory->content : '' !!}
                </div>
                <input type="hidden" name="content" id="content">
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition-all font-semibold">
                    {{ $theory ? 'Сохранить' : 'Создать' }}
                </button>
            </div>
        </div>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <script>
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Введите текст теории...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image', 'code-block'],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean']
                ]
            }
        });

        const form = document.querySelector('form');
        form.onsubmit = function() {
            const contentInput = document.querySelector('#content');
            contentInput.value = quill.root.innerHTML;
        }
    </script>
@endsection
