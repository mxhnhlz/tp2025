@extends('admin.layout')

@section('title', 'Редактировать вопрос')

@section('content')
    <div class="max-w-5xl mx-auto mt-6">
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200">

            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Редактирование вопроса</h1>
                <a href="{{ route('admin.questions.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all">
                    ← Назад
                </a>
            </div>

            <form action="{{ route('admin.questions.update', $question->id) }}"
                  method="POST"
                  x-data="editQuestionForm()"
                  @submit.prevent="submitForm($event)">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-full">
                        <label class="font-semibold text-gray-700 mb-1 block">Текст вопроса</label>
                        <textarea name="content" rows="3"
                                  class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-blue-500"
                                  required>{{ $question->content }}</textarea>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">К заданию</label>
                        <select name="task_id" class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500" required>
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}" {{ $question->task_id == $task->id ? 'selected' : '' }}>
                                    {{ $task->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Порядок вопроса</label>
                        <input type="number" name="order" class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500"
                               value="{{ $question->order }}" required>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Тип вопроса</label>
                        <select name="type" x-model="type" class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500" required>
                            <option value="single">Один правильный ответ</option>
                            <option value="multiple">Несколько правильных ответов</option>
                            <option value="text">Текстовый ответ</option>
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Подсказка</label>
                        <input type="text" name="hint" class="w-full rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500"
                               value="{{ $question->hint }}">
                    </div>
                </div>

                {{-- ANSWERS BLOCK --}}
                <div x-show="type !== 'text'" x-transition class="mt-8 bg-gray-50 rounded-2xl p-6 border border-gray-200 space-y-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="font-bold text-xl">Варианты ответов</h2>
                        <button type="button" class="px-4 py-1.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all" @click="addAnswer()">
                            + Добавить
                        </button>
                    </div>

                    <template x-for="(answer, index) in answers" :key="index">
                        <div class="bg-white border rounded-xl p-4 shadow-sm flex items-center gap-4">
                            <input type="text"
                                   :name="`answers[${index}][content]`"
                                   x-model="answer.content"
                                   class="flex-1 rounded-xl border p-2.5 focus:ring-2 focus:ring-blue-500"
                                   required>

                            <div class="flex items-center gap-3">
                                {{-- SINGLE --}}
                                <template x-if="type === 'single'">
                                    <div class="flex items-center gap-2">
                                        <input type="radio"
                                               :id="`edit_radio_${index}`"
                                               x-model.number="correctSingleIndex"
                                               :value="index"
                                               class="w-5 h-5 text-blue-600">
                                        <label :for="`edit_radio_${index}`" class="text-sm cursor-pointer">Правильный</label>
                                    </div>
                                </template>

                                {{-- MULTIPLE --}}
                                <template x-if="type === 'multiple'">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox"
                                               :id="`edit_check_${index}`"
                                               x-model="answer.correct"
                                               class="w-5 h-5 text-blue-600 rounded">
                                        <label :for="`edit_check_${index}`" class="text-sm cursor-pointer">Правильный</label>
                                    </div>
                                </template>

                                {{-- Скрытое поле is_correct для сервера --}}
                                <input type="hidden"
                                       :name="`answers[${index}][is_correct]`"
                                       :value="getIsCorrectValue(index)">

                                {{-- ID существующего ответа (важно для update в Laravel) --}}
                                <input type="hidden"
                                       :name="`answers[${index}][id]`"
                                       :value="answer.id">

                                <button type="button" class="text-red-600 font-bold hover:text-red-800 ml-2" @click="removeAnswer(index)" x-show="answers.length > 1">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- TEXT ANSWER --}}
                <div x-show="type === 'text'" x-transition class="mt-8 bg-gray-50 rounded-2xl p-6 border border-gray-200">
                    <h2 class="font-bold text-xl mb-3">Правильный текстовый ответ</h2>
                    <input type="text" name="correct_answer" class="w-full rounded-xl border p-3 focus:ring-2 focus:ring-blue-500"
                           value="{{ $question->type === 'text' ? optional($question->textAnswer)->correct_answer : '' }}"
                           placeholder="Введите правильный ответ">
                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-semibold text-lg transition-all shadow-md">
                        Сохранить изменения
                    </button>
                </div>
            </form>

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
        function editQuestionForm() {
            return {
                type: '{{ $question->type }}',
                // Находим индекс правильного ответа для типа single при загрузке
                correctSingleIndex: {{ $question->options->search(fn($o) => $o->is_correct) !== false ? $question->options->search(fn($o) => $o->is_correct) : 0 }},

                answers: [
                        @foreach($question->options as $option)
                    {
                        id: {{ $option->id }},
                        content: @json($option->content),
                        correct: {{ $option->is_correct ? 'true' : 'false' }},
                    },
                    @endforeach
                ],

                addAnswer() {
                    this.answers.push({id: null, content: '', correct: false});
                },

                removeAnswer(index) {
                    if (this.answers.length > 1) {
                        this.answers.splice(index, 1);
                        // Если удалили тот, что был выбран правильным в single mode
                        if (this.correctSingleIndex >= this.answers.length) {
                            this.correctSingleIndex = 0;
                        }
                    }
                },

                getIsCorrectValue(index) {
                    if (this.type === 'single') {
                        return this.correctSingleIndex === index ? '1' : '0';
                    }
                    return this.answers[index].correct ? '1' : '0';
                },

                submitForm(event) {
                    // Простая валидация
                    if (this.type === 'multiple' && !this.answers.some(a => a.correct)) {
                        alert('Выберите хотя бы один правильный ответ');
                        return;
                    }
                    event.target.submit();
                }
            }
        }
    </script>
@endsection
