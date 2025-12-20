@extends('admin.layout')

@section('title', 'Создать вопрос')

@section('content')
    <div class="max-w-5xl mx-auto mt-6">

        {{-- CARD --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Создание вопроса</h1>
                <a href="{{ route('admin.questions.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all">
                    ← Назад
                </a>
            </div>

            {{-- FORM --}}
            <form action="{{ route('admin.questions.store') }}" method="POST" x-data="questionForm()">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- TEXT --}}
                    <div class="col-span-full">
                        <label class="font-semibold text-gray-700 mb-1 block">Текст вопроса</label>
                        <textarea name="content" rows="3"
                                  class="w-full rounded-xl border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Введите формулировку вопроса" required></textarea>
                    </div>

                    {{-- TASK --}}
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">К заданию</label>
                        <select name="task_id"
                                class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}">{{ $task->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- ORDER FIELD --}}
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Порядок вопроса</label>
                        <input type="number" name="order"
                               class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Например: 1" value="1" required>
                    </div>

                    {{-- TYPE --}}
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Тип вопроса</label>
                        <select name="type" x-model="type"
                                class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="single">Один правильный ответ</option>
                            <option value="multiple">Несколько правильных ответов</option>
                            <option value="text">Текстовый ответ</option>
                        </select>
                    </div>

                    {{-- HINT --}}
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Подсказка (необязательно)</label>
                        <input type="text" name="hint"
                               class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Подсказка для пользователя">
                    </div>

                </div>

                {{-- ANSWERS --}}
                <div x-show="type !== 'text'"
                     x-transition
                     class="mt-8 bg-gray-50 rounded-2xl p-6 border border-gray-200 space-y-4">

                    <div class="flex justify-between items-center mb-2">
                        <h2 class="font-bold text-xl">Варианты ответов</h2>

                        <button type="button"
                                class="px-4 py-1.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all"
                                @click="addAnswer()">
                            + Добавить
                        </button>
                    </div>

                    <template x-for="(answer, index) in answers" :key="index">
                        <div class="bg-white border rounded-xl p-4 shadow-sm flex items-center gap-4">

                            <input type="text"
                                   :name="`answers[${index}][content]`"
                                   x-model="answer.content"
                                   class="flex-1 rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500"
                                   placeholder="Текст ответа" required>

                            {{-- MULTIPLE --}}
                            <template x-if="type === 'multiple'">
                                <input type="checkbox"
                                       class="w-5 h-5"
                                       :name="`answers[${index}][is_correct]`"
                                       x-model="answer.correct"
                                       value="1">
                            </template>

                            {{-- SINGLE --}}
                            <template x-if="type === 'single'">
                                <input type="radio"
                                       class="w-5 h-5"
                                       name="correct_single"
                                       :value="index"
                                       x-model="correctSingleIndex">
                            </template>

                            {{-- HIDDEN --}}
                            <input type="hidden"
                                   :name="`answers[${index}][is_correct]`"
                                   :value="type === 'single' && correctSingleIndex === index ? '1' : '0'">

                            <button type="button"
                                    class="text-red-600 font-bold hover:text-red-800 text-lg"
                                    @click="removeAnswer(index)">
                                ✕
                            </button>
                        </div>
                    </template>

                </div>

                {{-- TEXT ANSWER --}}
                <div x-show="type === 'text'"
                     x-transition
                     class="mt-8 bg-gray-50 rounded-2xl p-6 border border-gray-200">

                    <h2 class="font-bold text-xl mb-3">Правильный ответ</h2>

                    <input type="text" name="correct_answer"
                           class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-blue-500"
                           placeholder="Введите правильный текстовый ответ">
                </div>

                {{-- SUBMIT --}}
                <div class="mt-10 flex justify-end">
                    <button type="submit"
                            class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-semibold text-lg transition-all shadow-md">
                        Создать вопрос
                    </button>
                </div>
            </form>

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="mt-6 bg-red-50 border border-red-300 text-red-700 p-4 rounded-xl">
                    <ul class="list-disc ml-6 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>

    <script>
        function questionForm() {
            return {
                type: 'single',
                correctSingleIndex: 0,
                answers: [
                    {content: '', correct: false},
                ],

                addAnswer() {
                    this.answers.push({content: '', correct: false});
                },

                removeAnswer(index) {
                    if (this.answers.length > 1) {
                        this.answers.splice(index, 1);
                        if (this.correctSingleIndex >= this.answers.length) {
                            this.correctSingleIndex = 0;
                        }
                    }
                }
            }
        }
    </script>

@endsection
