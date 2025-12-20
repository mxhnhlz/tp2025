@extends('admin.layout')
@section('title', 'Превью раздела')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">

        <!-- Заголовок раздела -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $section->title }}</h1>
            @if($section->description)
                <p class="text-gray-700 text-lg">{{ $section->description }}</p>
            @endif
        </div>

        <!-- Задания -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Задания</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($section->tasks as $task)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 flex flex-col justify-between hover:shadow-xl transition-all" x-data="{ showTheory: false, showQuestions: false }">

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $task->title }}</h3>
                        @if($task->description)
                            <p class="text-gray-600 text-sm mb-2 max-h-24 overflow-hidden">{{ $task->description }}</p>
                        @endif
                        <div class="flex gap-2 flex-wrap">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($task->difficulty == 'easy') bg-green-100 text-green-800
                            @elseif($task->difficulty == 'medium') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($task->difficulty) }}
                        </span>
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Баллы: {{ $task->questions_sum_points }}</span>
                        </div>
                    </div>

                    <!-- Кнопки открытия модальных окон -->
                    <div class="mt-4 flex gap-3">
                        <button @click="showTheory = true"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                            Теория
                        </button>
                        <button @click="showQuestions = true"
                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                            Вопросы
                        </button>
                    </div>

                    <!-- Модальное окно: Теория -->
                    <div x-show="showTheory" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                         x-transition.opacity>
                        <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full p-6 relative"
                             x-transition.scale>
                            <button @click="showTheory = false"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Теория</h4>
                            <div class="text-gray-700 max-h-96 overflow-y-auto">
                                {!! $task->theory->content !!}
                            </div>
                            <div class="mt-4 text-right">
                                <button @click="showTheory = false"
                                        class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition-colors">
                                    Закрыть
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Модальное окно: Вопросы -->
                    <div x-show="showQuestions" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                         x-transition.opacity>
                        <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full p-6 relative"
                             x-transition.scale>
                            <button @click="showQuestions = false"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Вопросы</h4>

                            <div class="space-y-6 max-h-96 overflow-y-auto">
                                @foreach($task->questions as $index => $question)
                                    <div class="border p-4 rounded-lg">
                                        <div class="flex justify-between items-center mb-2">
                                            <p class="font-medium">{{ $index + 1 }}. {{ $question->content }}</p>
                                            <span class="text-sm text-gray-500 px-2 py-1 bg-gray-100 rounded-full">
                            {{ $question->points }} балл{{ ($question->points ?? $task->points) > 1 ? 'ов' : '' }}
                        </span>
                                        </div>

                                        @if($question->type === 'single' || $question->type === 'multiple')
                                            <div class="space-y-2">
                                                @foreach($question->options as $option)
                                                    <div class="flex items-center gap-2 p-2 rounded
                                    {{ $option->is_correct ? 'bg-green-100 border border-green-400' : '' }}">
                                                        <input type="{{ $question->type === 'single' ? 'radio' : 'checkbox' }}" disabled
                                                               class="form-radio cursor-not-allowed">
                                                        <span>{{ $option->content }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'text')
                                            <div class="bg-green-100 border border-green-400 rounded p-2">
                                                <span>{{ $question->textAnswers->where('question_id', $question->id)->first()->correct_answer }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 text-right">
                                <button @click="showQuestions = false"
                                        class="px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300 transition-colors">
                                    Закрыть
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
@endsection
