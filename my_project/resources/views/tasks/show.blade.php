@extends('layouts.app')

@section('content')
    <div
        x-data="taskData({{ $task->questions->toJson() }})"
        x-init="init()"
        class="min-h-screen overflow-hidden bg-gradient-to-br from-slate-950 via-purple-900/30 to-slate-950"
        style="background-image: radial-gradient(circle at 10% 20%, rgba(56, 189, 248, 0.15) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(168, 85, 247, 0.15) 0%, transparent 40%);"
    >
        <!-- Плавающие элементы фона -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            @for($i = 0; $i < 8; $i++)
                <div
                    class="absolute rounded-full bg-gradient-to-r {{ ['from-cyan-500/10', 'from-purple-500/10', 'from-blue-500/10', 'from-emerald-500/10'][$i % 4] }} to-transparent"
                    style="
                        top: {{ rand(10, 90) }}%;
                        left: {{ rand(10, 90) }}%;
                        width: {{ rand(40, 120) }}px;
                        height: {{ rand(40, 120) }}px;
                        animation: float {{ rand(8, 15) }}s ease-in-out infinite {{ $i * 0.3 }}s;
                        opacity: {{ rand(5, 15) / 100 }};
                    "
                ></div>
            @endfor
        </div>

        <!-- HEADER -->
        <header
            :class="scrolled ? 'bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-cyan-500/10' : 'bg-slate-900/20 backdrop-blur-md'"
            x-data="{ scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
            class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-white/5"
        >
            <nav class="container mx-auto px-4 sm:px-6 py-3">
                <div class="flex items-center justify-between">
                    <!-- Лого -->
                    <a href="{{ route('sections.index') }}" class="group flex items-center gap-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur group-hover:blur-md transition-all duration-300 opacity-70"></div>
                            <i data-lucide="arrow-left" class="w-6 h-6 text-cyan-400 relative z-10 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent hidden sm:block">
                            К разделам
                        </span>
                    </a>

                    <!-- Информация о задании -->
                    <div class="flex flex-col items-center text-center">
                        <h1 class="text-lg sm:text-xl font-bold text-white truncate max-w-[200px] sm:max-w-md">
                            {{ $task->title }}
                        </h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $task->difficulty === 'easy' ? 'bg-green-500/20 text-green-400 border border-green-500/30' :
                                   ($task->difficulty === 'medium' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' :
                                   'bg-red-500/20 text-red-400 border border-red-500/30') }}">
                                {{ $task->difficulty === 'easy' ? 'Легкий' :
                                   ($task->difficulty === 'medium' ? 'Средний' : 'Сложный') }}
                            </span>
                            <span class="text-xs text-gray-400 flex items-center">
                                <i data-lucide="star" class="w-3 h-3 text-yellow-400 mr-1"></i>
                                {{ $task->points }} XP
                            </span>
                        </div>
                    </div>

                    <!-- Профиль пользователя -->
                    <div class="flex items-center gap-2">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-xs text-gray-400">Уровень</span>
                            <span class="text-sm font-bold text-emerald-400">{{ auth()->user()->level }}</span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full blur opacity-50"></div>
                            <div class="relative w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center">
                                <i data-lucide="user" class="w-4 h-4 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- MAIN CONTENT -->
        <main class="pt-24 pb-16 px-4 sm:px-6">
            <div class="container mx-auto max-w-6xl">
                <!-- Теория -->
                <div
                    x-data="{ showTheory: true }"
                    class="mb-8"
                >
                    <!-- Переключатель теории/теста -->
                    <div class="flex justify-center mb-6">
                        <div class="inline-flex p-1 rounded-xl bg-slate-800/50 backdrop-blur-sm border border-white/10">
                            <button
                                @click="showTheory = true"
                                :class="showTheory ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                                class="px-6 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center gap-2"
                            >
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Теория</span>
                            </button>
                            <button
                                @click="showTheory = false"
                                :class="!showTheory ? 'bg-gradient-to-r from-purple-500 to-pink-600 text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                                class="px-6 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center gap-2"
                            >
                                <i data-lucide="list-checks" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Тест</span>
                                <span class="text-xs px-1.5 py-0.5 rounded-full bg-white/10" x-text="questions.length"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Контейнер теории -->
                    <div
                        x-show="showTheory"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4"
                        class="relative group"
                    >
                        <!-- Эффект свечения -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500/30 to-blue-500/30 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                        <!-- Карточка теории -->
                        <div class="relative p-6 sm:p-8 bg-slate-900/60 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl shadow-cyan-500/10">
                            <!-- Заголовок -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 border border-cyan-500/30">
                                        <i data-lucide="book-text" class="w-6 h-6 text-cyan-400"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-xl sm:text-2xl font-bold text-white">Теоретический материал</h2>
                                        <p class="text-sm text-gray-400">Изучите перед началом тестирования</p>
                                    </div>
                                </div>
                                <div class="text-right hidden sm:block">
                                    <div class="text-lg font-bold text-cyan-400">{{ $task->questions->count() }}</div>
                                    <div class="text-sm text-gray-400">вопросов</div>
                                </div>
                            </div>

                            <!-- Содержимое теории -->
                            <div class="prose prose-invert max-w-none">
                                <div class="text-gray-300 leading-relaxed space-y-4">
                                    @if($task->theory && $task->theory->content)
                                        {!! $task->theory->content !!}
                                    @else
                                        <div class="text-center py-8">
                                            <div class="inline-flex p-4 rounded-2xl bg-slate-800/50 border border-white/10 mb-4">
                                                <i data-lucide="book-x" class="w-12 h-12 text-gray-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-white mb-2">Теория отсутствует</h3>
                                            <p class="text-gray-400">Приступайте к тестированию</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Кнопка начала теста -->
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <button
                                    @click="showTheory = false; showQuestions = true"
                                    class="group relative w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 font-bold text-white
                                           hover:shadow-2xl hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-0.5"
                                >
                                    <span class="relative z-10 flex items-center justify-center gap-3">
                                        <span>Начать тестирование</span>
                                        <i data-lucide="play" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-xl blur opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                                </button>
                                <p class="text-center text-gray-400 mt-3 text-sm">
                                    После начала теста вы сможете отвечать на вопросы
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Вопросы -->
                <div
                    x-show="showQuestions"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="relative"
                >
                    <!-- Прогресс бар -->
                    <div class="mb-6 sm:mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-white">
                                <h2 class="text-xl sm:text-2xl font-bold">Тестирование</h2>
                                <p class="text-gray-400 text-sm">Отвечайте на вопросы по порядку</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="hidden sm:block text-white text-right">
                                    <div class="text-sm text-gray-400">Прогресс</div>
                                    <div class="text-lg font-bold" x-text="currentIndex + 1"></div>
                                </div>
                                <div class="w-32 bg-slate-800 rounded-full h-2 overflow-hidden border border-white/10">
                                    <div
                                        class="bg-gradient-to-r from-cyan-500 to-blue-600 h-2 rounded-full transition-all duration-500 ease-out"
                                        :style="'width: ' + ((currentIndex + 1) / questions.length * 100) + '%'"
                                    ></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center text-gray-400 text-sm sm:hidden">
                            Вопрос <span class="font-bold text-white" x-text="currentIndex + 1"></span> из <span class="font-bold text-white" x-text="questions.length"></span>
                        </div>
                    </div>

                    <!-- Контейнер вопроса -->
                    <template x-if="currentQuestion">
                        <div class="relative group mb-6">
                            <!-- Эффект свечения -->
                            <div
                                :class="hasAnswer ? 'opacity-100' : 'opacity-0'"
                                class="absolute -inset-1 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-3xl blur-xl transition-all duration-500"
                            ></div>

                            <!-- Карточка вопроса -->
                            <div class="relative p-6 sm:p-8 bg-slate-900/60 backdrop-blur-xl rounded-2xl border border-white/10 shadow-xl">
                                <!-- Заголовок вопроса -->
                                <div class="mb-6 sm:mb-8">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-xl bg-gradient-to-br from-purple-500/20 to-pink-600/20 border border-purple-500/30">
                                                <i data-lucide="help-circle" class="w-5 h-5 text-purple-400"></i>
                                            </div>
                                            <h3 class="text-lg sm:text-xl font-bold text-white">
                                                Вопрос <span x-text="currentIndex + 1"></span> из <span x-text="questions.length"></span>
                                            </h3>
                                        </div>
                                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-slate-800/80 text-gray-300 border border-white/10"
                                              x-text="currentQuestion.type === 'single' ? 'Один ответ' :
                                                     currentQuestion.type === 'multiple' ? 'Несколько ответов' : 'Текстовый ответ'">
                                        </span>
                                    </div>
                                    <div class="text-base sm:text-lg text-gray-300 leading-relaxed bg-slate-800/30 rounded-xl p-4 sm:p-6 border border-white/5"
                                         x-html="currentQuestion.content">
                                    </div>
                                </div>

                                <!-- Варианты ответов -->
                                <div class="space-y-3 sm:space-y-4 mb-8">
                                    <!-- Single choice -->
                                    <template x-if="currentQuestion.type === 'single'">
                                        <div class="space-y-3">
                                            <template x-for="(option, index) in currentQuestion.options" :key="option.id">
                                                <label class="group/option flex items-center p-4 bg-slate-800/30 rounded-xl cursor-pointer
                                                         hover:bg-slate-800/50 transition-all duration-300
                                                         border border-white/5 hover:border-cyan-500/30">
                                                    <input
                                                        type="radio"
                                                        :name="'q_' + currentQuestion.id"
                                                        :value="option.id"
                                                        x-model="answers[currentQuestion.id]"
                                                        @change="checkAnswer"
                                                        class="hidden peer"
                                                    >
                                                    <div class="flex-shrink-0 w-6 h-6 sm:w-7 sm:h-7 border-2 border-gray-600 rounded-full mr-4
                                                            flex items-center justify-center transition-all duration-300
                                                            peer-checked:bg-gradient-to-r peer-checked:from-cyan-500 peer-checked:to-blue-600 peer-checked:border-transparent
                                                            group-hover/option:border-gray-500 peer-checked:scale-110">
                                                        <div class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-white opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="text-gray-300 peer-checked:text-white font-medium transition-colors duration-300"
                                                             x-html="option.content"></div>
                                                    </div>
                                                    <div class="text-gray-500 text-sm font-bold ml-2">
                                                        <span x-text="String.fromCharCode(65 + index)"></span>
                                                    </div>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Multiple choice -->
                                    <template x-if="currentQuestion.type === 'multiple'">
                                        <div class="space-y-3">
                                            <template x-for="(option, index) in currentQuestion.options" :key="option.id">
                                                <label class="group/option flex items-center p-4 bg-slate-800/30 rounded-xl cursor-pointer
                                                         hover:bg-slate-800/50 transition-all duration-300
                                                         border border-white/5 hover:border-purple-500/30">
                                                    <input
                                                        type="checkbox"
                                                        :value="option.id"
                                                        x-model="answers[currentQuestion.id]"
                                                        @change="updateMultipleChoice(currentQuestion.id, option.id)"
                                                        class="hidden peer"
                                                    >
                                                    <div class="flex-shrink-0 w-6 h-6 sm:w-7 sm:h-7 border-2 border-gray-600 rounded mr-4
                                                            flex items-center justify-center transition-all duration-300
                                                            peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-pink-600 peer-checked:border-transparent
                                                            group-hover/option:border-gray-500 peer-checked:scale-110">
                                                        <i data-lucide="check" class="w-3 h-3 sm:w-4 sm:h-4 text-white opacity-0 peer-checked:opacity-100 transition-all duration-300"></i>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="text-gray-300 peer-checked:text-white font-medium transition-colors duration-300"
                                                             x-html="option.content"></div>
                                                    </div>
                                                    <div class="text-gray-500 text-sm font-bold ml-2">
                                                        <span x-text="String.fromCharCode(65 + index)"></span>
                                                    </div>
                                                </label>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Text input -->
                                    <template x-if="currentQuestion.type === 'text'">
                                        <div class="relative">
                                            <textarea
                                                x-model="answers[currentQuestion.id]"
                                                @input="checkAnswer"
                                                placeholder="Введите ваш ответ здесь..."
                                                rows="5"
                                                class="w-full p-4 sm:p-6 rounded-xl bg-slate-800/30 text-white border border-white/10
                                                       focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30
                                                       resize-none transition-all duration-300 placeholder-gray-500"
                                            ></textarea>
                                            <div class="absolute bottom-3 right-3 text-gray-500 text-sm" x-show="answers[currentQuestion.id]">
                                                <span x-text="(answers[currentQuestion.id] || '').length"></span> символов
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Подсказка -->
                                <div
                                    x-show="showHint && currentQuestion.hint"
                                    x-transition
                                    class="mt-6 p-4 bg-gradient-to-r from-blue-900/30 to-cyan-900/30 rounded-xl border border-cyan-800/50"
                                >
                                    <div class="flex items-start gap-3">
                                        <i data-lucide="lightbulb" class="w-5 h-5 text-cyan-400 mt-0.5 flex-shrink-0"></i>
                                        <div>
                                            <p class="text-cyan-300 font-medium mb-1">Подсказка:</p>
                                            <p class="text-cyan-200/80" x-text="currentQuestion.hint"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Кнопка показать подсказку -->
                                <button
                                    x-show="currentQuestion.hint && !showHint"
                                    @click="showHint = true"
                                    class="mt-4 w-full sm:w-auto px-4 py-2.5 text-sm text-cyan-400 hover:text-cyan-300
                                           border border-cyan-500/30 rounded-lg hover:bg-cyan-500/10 transition-all duration-300
                                           flex items-center justify-center gap-2"
                                >
                                    <i data-lucide="lightbulb" class="w-4 h-4"></i>
                                    Показать подсказку
                                </button>

                                <!-- Навигация по вопросам -->
                                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-white/10">
                                    <!-- Кнопка назад -->
                                    <button
                                        @click="prevQuestion"
                                        :disabled="currentIndex === 0"
                                        class="group w-full sm:w-auto px-6 py-3 bg-slate-800/50 rounded-xl text-white hover:bg-slate-700/50 transition-all
                                               flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <i data-lucide="chevron-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                                        Назад
                                    </button>

                                    <!-- Кнопка сохранить -->
                                    <div class="text-center order-first sm:order-none mb-4 sm:mb-0">
                                        <button
                                            @click="saveAnswer()"
                                            :disabled="!hasAnswer"
                                            class="group w-full sm:w-auto px-6 py-3 rounded-xl font-medium transition-all duration-300
                                                   flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                            :class="hasAnswer ?
                                                   'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white hover:shadow-lg hover:shadow-emerald-500/20' :
                                                   'bg-slate-800/50 text-gray-400'"
                                        >
                                            <i data-lucide="save" class="w-4 h-4 group-hover:rotate-12 transition-transform"></i>
                                            Сохранить ответ
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2" x-show="!hasAnswer">
                                            Выберите ответ чтобы сохранить
                                        </p>
                                    </div>

                                    <!-- Кнопка вперед/завершить -->
                                    <button
                                        @click="nextQuestion"
                                        class="group w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-xl text-white hover:from-cyan-600 hover:to-blue-700 transition-all
                                               flex items-center justify-center gap-2"
                                    >
                                        <span x-text="currentIndex + 1 < questions.length ? 'Следующий' : 'Завершить'"></span>
                                        <i data-lucide="chevron-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>

                                <!-- Прогресс точкими (для мобильных) -->
                                <div class="flex justify-center gap-2 mt-6 sm:hidden">
                                    <template x-for="(q, index) in questions" :key="q.id">
                                        <div
                                            :class="index <= currentIndex ? 'bg-cyan-500' : 'bg-slate-700'"
                                            class="w-2 h-2 rounded-full transition-all duration-300"
                                        ></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Результаты теста -->
                    <div
                        x-show="finished"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="relative group"
                    >
                        <!-- Эффект свечения -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500/20 via-cyan-500/20 to-blue-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>

                        <!-- Карточка результатов -->
                        <div class="relative p-6 sm:p-10 bg-slate-900/60 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl shadow-emerald-500/10">
                            <!-- Анимация завершения -->
                            <div class="text-center mb-8">
                                <div class="inline-flex p-4 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-cyan-600/20 border border-emerald-500/30 mb-6">
                                    <i data-lucide="trophy" class="w-12 h-12 sm:w-16 sm:h-16 text-emerald-400 animate-pulse"></i>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-bold text-white mb-3">Тест успешно завершен!</h3>
                                <p class="text-gray-400 text-lg">Отличная работа! Вы справились со всеми вопросами</p>
                            </div>

                            <!-- Статистика -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
                                <!-- Точность -->
                                <div class="group/stat relative p-6 bg-slate-800/30 rounded-xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300">
                                    <div class="text-center">
                                        <div class="text-4xl sm:text-5xl font-bold text-emerald-400 mb-2" x-text="accuracy + '%'"></div>
                                        <p class="text-gray-400">Точность ответов</p>
                                    </div>
                                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                                        <div class="w-4 h-4 bg-emerald-500 rotate-45"></div>
                                    </div>
                                </div>

                                <!-- Правильные ответы -->
                                <div class="group/stat relative p-6 bg-slate-800/30 rounded-xl border border-white/10 hover:border-cyan-500/30 transition-all duration-300">
                                    <div class="text-center">
                                        <div class="text-4xl sm:text-5xl font-bold text-cyan-400 mb-2">
                                            <span x-text="correctAnswers"></span>/<span x-text="totalQuestions"></span>
                                        </div>
                                        <p class="text-gray-400">Правильные ответы</p>
                                    </div>
                                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                                        <div class="w-4 h-4 bg-cyan-500 rotate-45"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Награда -->
                            <div class="bg-gradient-to-r from-amber-900/20 to-yellow-900/20 p-6 rounded-xl mb-8 border border-amber-800/30">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 rounded-xl bg-gradient-to-br from-yellow-500/20 to-amber-600/20 border border-amber-500/30">
                                            <i data-lucide="award" class="w-8 h-8 text-yellow-400"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-white mb-1">Награда за прохождение</h4>
                                            <p class="text-gray-400 text-sm">Вы получили опыт за успешное завершение</p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-3xl font-bold text-yellow-400" x-text="xpGained + ' XP'"></div>
                                        <p class="text-gray-400 text-sm">+ к общему прогрессу</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки действий -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('sections.index') }}"
                                   class="group relative px-6 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-xl text-white font-bold
                                          hover:shadow-2xl hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-1
                                          flex items-center justify-center gap-3"
                                >
                                    <i data-lucide="grid" class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300"></i>
                                    К разделам
                                </a>

                                <a href="{{ route('dashboard') }}"
                                   class="group relative px-6 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl text-white font-bold
                                          hover:shadow-2xl hover:shadow-emerald-500/30 transition-all duration-300 transform hover:-translate-y-1
                                          flex items-center justify-center gap-3"
                                >
                                    <i data-lucide="user" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                                    В личный кабинет
                                </a>
                            </div>

                            <p class="text-center text-gray-500 text-sm mt-6">
                                Ваш прогресс сохранен. Вы можете вернуться к этому заданию в любое время.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Мобильная навигация (fixed внизу) -->
        <div class="fixed bottom-0 left-0 right-0 bg-slate-900/90 backdrop-blur-xl py-3 px-4 border-t border-white/10 z-40 sm:hidden">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="text-xs text-gray-400">Вопрос:</div>
                    <div class="text-sm font-bold text-white" x-text="currentIndex + 1"></div>
                    <div class="text-xs text-gray-400">/</div>
                    <div class="text-sm text-gray-300" x-text="questions.length"></div>
                </div>
                <button
                    @click="$dispatch('toggle-mode')"
                    class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-lg text-white text-sm font-medium flex items-center gap-2"
                >
                    <i data-lucide="book-open" class="w-4 h-4" x-show="showQuestions"></i>
                    <i data-lucide="list-checks" class="w-4 h-4" x-show="!showQuestions"></i>
                    <span x-text="showQuestions ? 'Теория' : 'Тест'"></span>
                </button>
            </div>
        </div>
    </div>

    <script>
        function taskData(rawQuestions) {
            return {
                // Состояние
                showQuestions: false,
                showHint: false,
                questions: rawQuestions,
                answers: {},
                currentIndex: 0,
                finished: false,
                accuracy: 0,
                correctAnswers: 0,
                totalQuestions: rawQuestions.length,
                xpGained: 0,
                hasAnswer: false,

                init() {
                    // Инициализация multiple choice как пустых массивов
                    this.questions.forEach(q => {
                        if (q.type === 'multiple') {
                            if (!this.answers[q.id]) {
                                this.answers[q.id] = [];
                            }
                        }
                    });

                    // Инициализация Lucide иконок
                    this.$nextTick(() => {
                        if (window.lucide) {
                            lucide.createIcons();
                        }
                    });

                    this.checkAnswer();

                    // Прокрутка вверх при смене вопроса
                    this.$watch('currentIndex', () => {
                        setTimeout(() => {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }, 100);
                    });
                },

                get currentQuestion() {
                    return this.questions[this.currentIndex] ?? null;
                },

                checkAnswer() {
                    const q = this.currentQuestion;
                    if (!q) {
                        this.hasAnswer = false;
                        return;
                    }

                    if (q.type === 'multiple') {
                        this.hasAnswer = this.answers[q.id] && this.answers[q.id].length > 0;
                    } else if (q.type === 'single' || q.type === 'text') {
                        this.hasAnswer = this.answers[q.id] && this.answers[q.id].toString().trim() !== '';
                    } else {
                        this.hasAnswer = false;
                    }
                },

                updateMultipleChoice(questionId, optionId) {
                    if (!Array.isArray(this.answers[questionId])) {
                        this.answers[questionId] = [];
                    }

                    const index = this.answers[questionId].indexOf(optionId);
                    if (index === -1) {
                        this.answers[questionId].push(optionId);
                    } else {
                        this.answers[questionId].splice(index, 1);
                    }

                    this.checkAnswer();
                },

                async saveAnswer() {
                    if (!this.hasAnswer) {
                        this.showNotification('Пожалуйста, выберите ответ перед сохранением', 'error');
                        return;
                    }

                    const question = this.currentQuestion;
                    let data = {
                        question_id: question.id,
                        _token: '{{ csrf_token() }}'
                    };

                    if (question.type === 'multiple') {
                        data.answers = this.answers[question.id] || [];
                    } else {
                        data.answer = this.answers[question.id] || '';
                    }

                    try {
                        const response = await fetch('{{ route("tasks.answer", $task->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.showNotification('Ответ сохранен!', 'success');
                            if (result.is_correct) {
                                this.showHint = false;
                            }
                        } else {
                            this.showNotification('Ошибка при сохранении ответа', 'error');
                        }
                    } catch (error) {
                        console.error('Ошибка сети:', error);
                        this.showNotification('Ошибка соединения', 'error');
                    }
                },

                nextQuestion() {
                    this.showHint = false;

                    if (this.currentIndex + 1 < this.questions.length) {
                        this.currentIndex++;
                        this.checkAnswer();
                    } else {
                        this.completeTest();
                    }
                },

                prevQuestion() {
                    this.showHint = false;
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                        this.checkAnswer();
                    }
                },

                async completeTest() {
                    try {
                        const response = await fetch('{{ route("tasks.complete", $task->id) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                _token: '{{ csrf_token() }}',
                                answers: this.answers
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.accuracy = Math.round(result.accuracy || 0);
                            this.correctAnswers = result.correct_answers || 0;
                            this.totalQuestions = result.total_questions || this.questions.length;
                            this.xpGained = result.xp_gained || Math.round(this.accuracy * ({{ $task->points }} || 10) / 100);
                            this.finished = true;

                            // Прокрутка к результатам
                            setTimeout(() => {
                                const resultsElement = document.querySelector('[x-show="finished"]');
                                if (resultsElement) {
                                    resultsElement.scrollIntoView({ behavior: 'smooth' });
                                }
                            }, 100);

                            this.showNotification('Тест успешно завершен!', 'success');
                        }
                    } catch (error) {
                        console.error('Ошибка завершения теста:', error);
                        this.showNotification('Ошибка при завершении теста', 'error');
                    }
                },

                showNotification(message, type = 'info') {
                    // Создание временного уведомления
                    const notification = document.createElement('div');
                    notification.className = `fixed top-24 right-4 z-50 px-4 py-3 rounded-lg border transform -translate-y-2 opacity-0 transition-all duration-300 ${
                        type === 'success' ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400' :
                            type === 'error' ? 'bg-red-500/10 border-red-500/30 text-red-400' :
                                'bg-blue-500/10 border-blue-500/30 text-blue-400'
                    }`;
                    notification.innerHTML = `
                        <div class="flex items-center gap-2">
                            <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'alert-circle' : 'info'}" class="w-5 h-5"></i>
                            <span>${message}</span>
                        </div>
                    `;

                    document.body.appendChild(notification);

                    // Анимация появления
                    setTimeout(() => {
                        notification.classList.remove('opacity-0', '-translate-y-2');
                        notification.classList.add('opacity-100', 'translate-y-0');
                    }, 10);

                    // Удаление через 3 секунды
                    setTimeout(() => {
                        notification.classList.remove('opacity-100', 'translate-y-0');
                        notification.classList.add('opacity-0', '-translate-y-2');
                        setTimeout(() => notification.remove(), 300);
                    }, 3000);

                    // Инициализация иконок
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                }
            }
        }
    </script>

    @push('styles')
        <style>
            @keyframes float {
                0%, 100% {
                    transform: translateY(0) rotate(0deg);
                }
                50% {
                    transform: translateY(-20px) rotate(180deg);
                }
            }

            .prose-invert {
                color: #d1d5db;
            }

            .prose-invert h1,
            .prose-invert h2,
            .prose-invert h3,
            .prose-invert h4 {
                color: #f3f4f6;
            }

            .prose-invert a {
                color: #38bdf8;
            }

            .prose-invert code {
                background: rgba(30, 41, 59, 0.5);
                color: #7dd3fc;
                padding: 0.2em 0.4em;
                border-radius: 0.25em;
                border: 1px solid rgba(56, 189, 248, 0.3);
            }

            .prose-invert pre {
                background: rgba(15, 23, 42, 0.7);
                border: 1px solid rgba(56, 189, 248, 0.3);
                border-radius: 0.5em;
                padding: 1em;
                overflow-x: auto;
            }

            .prose-invert blockquote {
                border-left-color: #38bdf8;
                background: rgba(56, 189, 248, 0.1);
                border-radius: 0 0.5em 0.5em 0;
            }

            /* Кастомный скроллбар */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(15, 23, 42, 0.5);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #06b6d4, #3b82f6);
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #0891b2, #2563eb);
            }

            /* Анимации для интерактивных элементов */
            .group-hover\/option .group-hover\/option\:border-gray-500 {
                transition: border-color 0.3s ease;
            }

            /* Адаптивные стили */
            @media (max-width: 640px) {
                .prose-invert {
                    font-size: 0.875rem;
                }

                .prose-invert h2 {
                    font-size: 1.25rem;
                }

                .prose-invert h3 {
                    font-size: 1.125rem;
                }
            }

            /* Эффект для выбранных ответов */
            .peer:checked ~ div {
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
            }

            /* Плавные переходы */
            * {
                scroll-behavior: smooth;
            }

            /* Улучшение читаемости на мобильных */
            @media (max-width: 768px) {
                .text-balance {
                    text-wrap: balance;
                }
            }
        </style>
    @endpush
@endsection
