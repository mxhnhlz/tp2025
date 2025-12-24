@extends('admin.layout')

@section('title', 'Создать вопрос')

@section('content')
    <div class="max-w-5xl mx-auto mt-6">
        <div class="bg-white shadow-xl rounded-2xl p-8 border">
            <h1 class="text-3xl font-bold mb-8">Создание вопроса</h1>

            <form method="POST"
                  action="{{ route('admin.questions.store') }}"
                  x-data="questionForm()"
                  @submit.prevent="submitForm($event)">

                @csrf

                {{-- Вопрос --}}
                <label class="block font-semibold mb-1">Текст вопроса</label>
                <textarea name="content" required
                          class="w-full border rounded p-3 mb-4"
                          placeholder="Введите текст вопроса"></textarea>

                {{-- Задание --}}
                <label class="block font-semibold mb-1">К заданию</label>
                <select name="task_id" required class="w-full border rounded p-2 mb-4">
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>

                {{-- Порядок --}}
                <label class="block font-semibold mb-1">Порядок</label>
                <input type="number" name="order" value="1" min="1"
                       class="w-full border rounded p-2 mb-4">

                {{-- Тип --}}
                <label class="block font-semibold mb-1">Тип вопроса</label>
                <select name="type" x-model="type" class="w-full border rounded p-2 mb-6">
                    <option value="single">Один правильный</option>
                    <option value="multiple">Несколько правильных</option>
                    <option value="text">Текстовый</option>
                </select>

                {{-- ANSWERS --}}
                <template x-if="type !== 'text'">
                    <div class="bg-gray-50 p-6 rounded-xl mb-6 border border-gray-200">
                        <h2 class="font-bold text-xl mb-4">Варианты ответов</h2>

                        <div class="space-y-4">
                            <template x-for="(answer, index) in answers" :key="index">
                                <div class="bg-white border rounded-xl p-4 shadow-sm flex items-center gap-4">
                                    {{-- Текст ответа --}}
                                    <div class="flex-1">
                                        <input type="text"
                                               class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               :name="`answers[${index}][content]`"
                                               x-model="answer.content"
                                               placeholder="Текст варианта ответа"
                                               required>
                                    </div>

                                    {{-- Выбор правильного ответа --}}
                                    <div class="flex items-center gap-4">
                                        {{-- SINGLE --}}
                                        <template x-if="type === 'single'">
                                            <div class="flex items-center gap-2">
                                                <input type="radio"
                                                       :id="`radio_${index}`"
                                                       x-model.number="correctIndex"
                                                       :value="index"
                                                       class="h-5 w-5 text-blue-600 focus:ring-blue-500">
                                                <label :for="`radio_${index}`"
                                                       class="text-sm font-medium text-gray-700 cursor-pointer">
                                                    Правильный
                                                </label>
                                            </div>
                                        </template>

                                        {{-- MULTIPLE --}}
                                        <template x-if="type === 'multiple'">
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox"
                                                       :id="`check_${index}`"
                                                       x-model="answer.correct"
                                                       class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                                                <label :for="`check_${index}`"
                                                       class="text-sm font-medium text-gray-700 cursor-pointer">
                                                    Правильный
                                                </label>
                                            </div>
                                        </template>

                                        {{-- Скрытое поле для отправки значения --}}
                                        <input type="hidden"
                                               :name="`answers[${index}][is_correct]`"
                                               :value="getIsCorrectValue(index)">

                                        {{-- Кнопка удаления --}}
                                        <button type="button"
                                                @click="removeAnswer(index)"
                                                class="text-red-600 hover:text-red-800 p-2 text-lg font-bold"
                                                x-show="answers.length > 2"
                                                title="Удалить вариант">
                                            ✕
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <button type="button"
                                @click="addAnswer"
                                class="mt-6 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                            + Добавить вариант ответа
                        </button>
                    </div>
                </template>

                {{-- TEXT ANSWER --}}
                <template x-if="type === 'text'">
                    <div class="bg-gray-50 p-6 rounded-xl mb-6 border border-gray-200">
                        <h2 class="font-bold text-xl mb-3">Правильный текстовый ответ</h2>
                        <input type="text"
                               name="correct_answer"
                               required
                               class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Введите правильный ответ">
                    </div>
                </template>

                {{-- Подсказка --}}
                <div class="mb-8">
                    <label class="block font-semibold mb-2 text-gray-700">Подсказка (необязательно)</label>
                    <textarea name="hint"
                              class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              rows="3"
                              placeholder="Подсказка для пользователя"></textarea>
                </div>

                {{-- Кнопки действий --}}
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit"
                            class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 font-semibold text-lg transition-all shadow-md">
                        Создать вопрос
                    </button>
                    <a href="{{ route('admin.questions.index') }}"
                       class="px-8 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 font-semibold text-lg transition-all">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function questionForm() {
            return {
                type: 'single',
                correctIndex: 0,
                answers: [
                    { content: '', correct: false },
                    { content: '', correct: false },
                ],

                addAnswer() {
                    this.answers.push({ content: '', correct: false });
                },

                removeAnswer(index) {
                    if (this.answers.length > 2) {
                        if (this.type === 'single' && index <= this.correctIndex) {
                            if (index === this.correctIndex) {
                                this.correctIndex = 0;
                            } else {
                                this.correctIndex = Math.max(0, this.correctIndex - 1);
                            }
                        }
                        this.answers.splice(index, 1);
                    }
                },

                getIsCorrectValue(index) {
                    if (this.type === 'single') {
                        return this.correctIndex === index ? '1' : '0';
                    } else if (this.type === 'multiple') {
                        return this.answers[index].correct ? '1' : '0';
                    }
                    return '0';
                },

                submitForm(event) {
                    // Валидация перед отправкой
                    if (this.type === 'single') {
                        if (this.correctIndex === null || this.correctIndex === undefined) {
                            alert('Выберите правильный ответ!');
                            return;
                        }
                    }

                    if (this.type === 'multiple') {
                        const hasCorrect = this.answers.some(a => a.correct);
                        if (!hasCorrect) {
                            alert('Выберите хотя бы один правильный ответ!');
                            return;
                        }
                    }

                    // Ручная отправка формы
                    event.target.submit();
                }
            }
        }
    </script>
@endsection
