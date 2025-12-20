@extends('admin.layout')

@section('title', 'Просмотр вопроса')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6 space-y-6">

        <h1 class="text-2xl font-bold">Просмотр вопроса</h1>

        {{-- Блок с информацией о вопросе --}}
        <div>
            <label class="block font-semibold mb-1">Текст вопроса</label>
            <div class="w-full border rounded p-2 bg-gray-100">{{ $question->content }}</div>
        </div>

        <div>
            <label class="block font-semibold mb-1">К заданию</label>
            <div class="w-full border rounded p-2 bg-gray-100">{{ $question->task->title }}</div>
        </div>

        <div>
            <label class="block font-semibold mb-1">Тип вопроса</label>
            <div class="w-full border rounded p-2 bg-gray-100">{{ ucfirst($question->type) }}</div>
        </div>

        @if($question->hint)
            <div>
                <label class="block font-semibold mb-1">Подсказка</label>
                <div class="w-full border rounded p-2 bg-gray-100">{{ $question->hint }}</div>
            </div>
        @endif

        {{-- Варианты ответов для single/multiple --}}
        @if($question->type === 'single' || $question->type === 'multiple')
            <div class="space-y-2">
                <label class="block font-semibold mb-1">Варианты ответов</label>
                <div class="space-y-2">
                    @foreach($question->options as $index => $answer)
                        <div class="p-3 border rounded-lg flex items-center gap-3 bg-gray-50">
                            <div class="flex-1">{{ $answer->content }}</div>
                            @if($question->type === 'single')
                                <div class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    {{ $answer->is_correct ? '✔' : '' }}
                                </div>
                            @elseif($question->type === 'multiple')
                                <div class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    {{ $answer->is_correct ? '✔' : '' }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Текстовый ответ --}}
        @if($question->type === 'text')
            <div>
                <label class="block font-semibold mb-1">Правильный ответ</label>
                <div class="bg-green-100 w-full border rounded p-2 bg-gray-100">{{ $question->textAnswers->where('question_id', '=', $question->id)->first()->correct_answer }}</div>
            </div>
        @endif

        {{-- Кнопка назад --}}
        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.questions.index') }}"
               class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition-colors">
                Назад
            </a>
        </div>

    </div>
@endsection
