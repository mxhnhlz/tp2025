@extends('layouts.app')

@section('content')
    <div
        x-data="taskData({{ $task->questions->toJson() }})"
        x-init="init()"
        class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 pt-32 px-6"
    >
        <!-- HEADER -->
        <header
            :class="isMenuOpen ? 'bg-slate-900/95 backdrop-blur-md shadow-lg' : 'bg-slate-900'"
            class="fixed top-0 w-full z-50 transition-all duration-300"
        >
            <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield" class="w-8 h-8 text-cyan-400"></i>
                    <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    CyberSafe Trainer
                </span>
                </div>

                <div class="hidden md:flex gap-4 items-center">
                    <a href="{{ route('home') }}" class="hover:text-cyan-400">Главная</a>
                    <a href="{{ route('sections.index') }}" class="hover:text-cyan-400">Разделы</a>

                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full font-semibold text-white hover:shadow-lg transition-all">
                            Личный кабинет
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-semibold text-white hover:shadow-lg transition-all">
                            Регистрация
                        </a>
                    @endauth

                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                                Выйти
                            </button>
                        </form>
                    @endauth
                </div>

                <button class="md:hidden" @click="isMenuOpen = !isMenuOpen">
                    <i x-show="!isMenuOpen" data-lucide="menu"></i>
                    <i x-show="isMenuOpen" data-lucide="x"></i>
                </button>
            </nav>

            <div x-show="isMenuOpen" class="md:hidden px-6 pb-4 space-y-4 bg-slate-900/95 backdrop-blur-md">
                <a href="{{ route('home') }}" class="block">Главная</a>
                <a href="{{ route('sections.index') }}" class="block">Разделы</a>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="block px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full font-semibold text-white text-center">
                        Личный кабинет
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="block px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-semibold text-white text-center">
                        Регистрация
                    </a>
                @endauth

                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                            Выйти
                        </button>
                    </form>
                @endauth
            </div>
        </header>

        <!-- CONTENT -->
        <div class="container mx-auto max-w-3xl">
            <!-- Теория -->
            <div class="bg-slate-800/50 p-6 rounded mb-8">
                <h2 class="text-2xl font-bold text-cyan-400 mb-4">{{ $task->title }}</h2>
                <p class="text-gray-300">{!! $task->theory->content ?? 'Теория пока отсутствует' !!}</p>
                <button x-show="!showQuestions"
                        @click="showQuestions = true"
                        class="mt-4 px-4 py-2 bg-cyan-500 rounded text-white hover:bg-cyan-600 transition">
                    Перейти к вопросам
                </button>
            </div>

            <!-- Вопросы -->
            <div x-show="showQuestions">
                <template x-if="currentQuestion">
                    <div class="bg-slate-800/50 p-6 rounded mb-4">
                        <h4 class="font-bold text-white mb-2" x-text="currentQuestion.content"></h4>

                        <!-- Single choice -->
                        <template x-if="currentQuestion.type === 'single'">
                            <div>
                                <template x-for="option in currentQuestion.options" :key="option.id">
                                    <label class="block text-gray-300 mb-1">
                                        <input type="radio"
                                               :name="'q_' + currentQuestion.id"
                                               :value="option.id"
                                               x-model="answers[currentQuestion.id]"
                                               class="mr-2">
                                        <span x-text="option.content"></span>
                                    </label>
                                </template>
                            </div>
                        </template>

                        <!-- Multiple choice -->
                        <template x-if="currentQuestion.type === 'multiple'">
                            <div>
                                <template x-for="option in currentQuestion.options" :key="option.id">
                                    <label class="block text-gray-300 mb-1">
                                        <input type="checkbox"
                                               :value="option.id"
                                               x-model="answers[currentQuestion.id]"
                                               class="mr-2">
                                        <span x-text="option.content"></span>
                                    </label>
                                </template>
                            </div>
                        </template>

                        <!-- Text -->
                        <template x-if="currentQuestion.type === 'text'">
                            <input type="text"
                                   x-model="answers[currentQuestion.id]"
                                   placeholder="Введите ответ"
                                   class="w-full mt-2 p-2 rounded text-black">
                        </template>

                        <!-- Навигация -->
                        <div class="flex justify-between mt-4">
                            <button @click="prevQuestion"
                                    class="px-4 py-2 bg-gray-500 rounded text-white hover:bg-gray-600 transition"
                                    :disabled="currentIndex === 0">Назад</button>
                            <button @click="nextQuestion"
                                    class="px-4 py-2 bg-cyan-500 rounded text-white hover:bg-cyan-600 transition"
                                    x-text="currentIndex + 1 < questions.length ? 'Следующий' : 'Завершить'">
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Результаты -->
                <div x-show="finished" class="bg-slate-800/50 p-6 rounded text-center">
                    <h3 class="text-2xl font-bold text-cyan-400 mb-2">Результаты</h3>
                    <p class="text-gray-300 text-lg mb-4">Вы ответили правильно на <span x-text="accuracy"></span>% вопросов</p>
                    <a href="{{ route('sections.index') }}"
                       class="px-4 py-2 bg-cyan-500 rounded text-white hover:bg-cyan-600 transition">
                        Вернуться к разделам
                    </a>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="py-8 border-t border-white/10 text-center mt-16">
            <p class="text-gray-400">© 2025 CyberSafe Trainer</p>
        </footer>
    </div>

    <script>
        function taskData(rawQuestions) {
            return {
                isMenuOpen: false,
                showQuestions: false,
                questions: rawQuestions,
                answers: {},
                currentIndex: 0,
                finished: false,
                accuracy: 0,

                init() {
                    // Инициализация multiple choice массивов
                    this.questions.forEach(q => {
                        if (q.type === 'multiple' && !this.answers[q.id]) {
                            this.answers[q.id] = [];
                        }
                    })
                },

                get currentQuestion() {
                    return this.questions[this.currentIndex] ?? null;
                },

                nextQuestion() {
                    if (this.currentIndex + 1 < this.questions.length) {
                        this.currentIndex++;
                    } else {
                        this.calculateAccuracy();
                    }
                },

                prevQuestion() {
                    if (this.currentIndex > 0) this.currentIndex--;
                },

                calculateAccuracy() {
                    let correctCount = 0;
                    this.questions.forEach(q => {
                        if (q.type === 'single') {
                            if (this.answers[q.id] == q.options.find(o => o.is_correct).id) correctCount++;
                        } else if (q.type === 'multiple') {
                            let correctIds = q.options.filter(o => o.is_correct).map(o => o.id).sort();
                            let userIds = (this.answers[q.id] || []).slice().sort();
                            if (JSON.stringify(correctIds) === JSON.stringify(userIds)) correctCount++;
                        } else if (q.type === 'text') {
                            let correctAnswer = q.textAnswer?.correct_answer?.toLowerCase().trim();
                            let userAnswer = (this.answers[q.id] || '').toLowerCase().trim();
                            if (correctAnswer === userAnswer) correctCount++;
                        }
                    });

                    this.accuracy = Math.round((correctCount / this.questions.length) * 100);
                    this.finished = true;
                }
            }
        }
    </script>
@endsection
