@extends('layouts.app')

@section('content')
    <div
        x-data="{
            isMenuOpen: false,
            showModal: false,
            selectedSection: null,
            tasks: [],
            floatingElements: [],
            hoveredSection: null,
            init() {
                this.createFloatingElements();
                this.$nextTick(() => {
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                });
            },
            createFloatingElements() {
                const elements = [];
                const colors = ['from-cyan-400/10', 'from-blue-500/10', 'from-purple-500/10', 'from-emerald-500/10'];

                for (let i = 0; i < 12; i++) {
                    elements.push({
                        id: i,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        size: Math.random() * 40 + 20,
                        top: Math.random() * 100,
                        left: Math.random() * 100,
                        speed: Math.random() * 2 + 0.5,
                        delay: i * 0.3
                    });
                }
                this.floatingElements = elements;
            },
            async openModal(sectionId) {
                this.selectedSection = sectionId;
                try {
                    const response = await fetch(`/sections/${sectionId}/tasks-json`);
                    const data = await response.json();
                    this.tasks = data;
                    this.showModal = true;
                    document.body.classList.add('overflow-hidden');
                } catch (error) {
                    console.error('Error fetching tasks:', error);
                }
            },
            closeModal() {
                this.showModal = false;
                this.selectedSection = null;
                this.tasks = [];
                document.body.classList.remove('overflow-hidden');
            },
            goToTask(taskId) {
                window.location.href = `/tasks/${taskId}`;
            },
            getSectionColor(index) {
                const colors = ['cyan', 'blue', 'purple', 'emerald', 'orange', 'pink'];
                return colors[index % colors.length];
            }
        }"
        class="min-h-screen bg-gradient-to-br from-slate-950 via-gray-900 to-slate-950"
    >

        <!-- Анимированный фон -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <template x-for="element in floatingElements" :key="element.id">
                <div
                    :class="'absolute rounded-full bg-gradient-to-r ' + element.color + ' to-transparent'"
                    :style="`
                        top: ${element.top}%;
                        left: ${element.left}%;
                        width: ${element.size}px;
                        height: ${element.size}px;
                        animation: float ${3 + element.speed}s ease-in-out infinite;
                        animation-delay: ${element.delay}s;
                        opacity: 0.08;
                    `"
                ></div>
            </template>

            <!-- Градиентные акценты -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- HEADER -->
        <header
            :class="isMenuOpen ? 'bg-slate-900/90 backdrop-blur-xl' : 'bg-slate-900/80 backdrop-blur-md'"
            class="fixed top-0 w-full z-40 transition-all duration-300 border-b border-white/10 shadow-lg shadow-cyan-500/5"
        >
            <nav class="container mx-auto px-4 sm:px-6 py-3">
                <div class="flex items-center justify-between">
                    <!-- Лого -->
                    <a href="{{ url('/') }}" class="group flex items-center gap-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-cyan-500 rounded-full blur group-hover:blur-md transition-all duration-300 opacity-70"></div>
                            <i data-lucide="shield" class="w-9 h-9 text-cyan-400 relative z-10 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient">
                            CyberSafe
                        </span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ url('/') }}"
                           class="px-4 py-2.5 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all duration-200">
                            Главная
                        </a>
                        <a href="{{ route('sections.index') }}"
                           class="px-4 py-2.5 rounded-lg bg-cyan-500/10 text-cyan-400 border border-cyan-500/30">
                            Разделы
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}"
                               class="ml-4 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-medium rounded-lg
                                      hover:shadow-lg hover:shadow-emerald-500/25 transition-all duration-300">
                                Кабинет
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="ml-4 px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-medium rounded-lg
                                      hover:shadow-lg hover:shadow-cyan-500/25 transition-all duration-300">
                                Вход
                            </a>
                        @endauth

                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2.5 text-gray-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg
                                               border border-transparent hover:border-red-500/30 transition-all duration-200">
                                    <i data-lucide="log-out" class="w-5 h-5"></i>
                                </button>
                            </form>
                        @endauth
                    </div>

                    <!-- Mobile button -->
                    <button @click="isMenuOpen = !isMenuOpen" class="md:hidden p-2.5 rounded-lg hover:bg-white/5 transition-colors">
                        <i x-show="!isMenuOpen" data-lucide="menu" class="w-6 h-6 text-white"></i>
                        <i x-show="isMenuOpen" data-lucide="x" class="w-6 h-6 text-white"></i>
                    </button>
                </div>

                <!-- Mobile menu -->
                <div x-show="isMenuOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="md:hidden mt-3 pt-3 border-t border-white/10">
                    <div class="space-y-1">
                        <a href="{{ url('/') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
                            <i data-lucide="home" class="w-5 h-5"></i>
                            Главная
                        </a>
                        <a href="{{ route('sections.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-lg bg-cyan-500/10 text-cyan-400 border border-cyan-500/30">
                            <i data-lucide="folder-open" class="w-5 h-5"></i>
                            Разделы
                        </a>

                        <div class="pt-2 space-y-2">
                            @auth
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600
                                          text-white font-medium rounded-lg">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                    Личный кабинет
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-600
                                          text-white font-medium rounded-lg">
                                    <i data-lucide="log-in" class="w-5 h-5"></i>
                                    Войти / Регистрация
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- MAIN CONTENT -->
        <main class="pt-24 pb-16 px-4 sm:px-6">
            <div class="container mx-auto max-w-6xl">
                <!-- Заголовок -->
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-cyan-500/10 border border-cyan-500/30 mb-6">
                        <i data-lucide="book-open" class="w-5 h-5 text-cyan-400"></i>
                        <span class="text-cyan-400 font-medium">Обучение</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4">
                        Разделы
                        <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                            обучения
                        </span>
                    </h1>
                    <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                        Выберите тему для изучения материалов
                    </p>
                </div>

                <!-- Сетка разделов -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sections as $section)
                        @php
                            $totalTasks = $section->tasks->count();
                            $completedTasks = $section->tasks->filter(fn($task) => $task->userProgress->count() > 0)->count();
                            $progress = $totalTasks ? ($completedTasks / $totalTasks) * 100 : 0;
                            $colorIndex = $loop->index % 6;
                            $colors = [
                                ['from-cyan-500', 'to-cyan-600', 'text-cyan-400', 'border-cyan-500/30', 'bg-cyan-500/10'],
                                ['from-blue-500', 'to-blue-600', 'text-blue-400', 'border-blue-500/30', 'bg-blue-500/10'],
                                ['from-purple-500', 'to-purple-600', 'text-purple-400', 'border-purple-500/30', 'bg-purple-500/10'],
                                ['from-emerald-500', 'to-emerald-600', 'text-emerald-400', 'border-emerald-500/30', 'bg-emerald-500/10'],
                                ['from-orange-500', 'to-orange-600', 'text-orange-400', 'border-orange-500/30', 'bg-orange-500/10'],
                                ['from-pink-500', 'to-pink-600', 'text-pink-400', 'border-pink-500/30', 'bg-pink-500/10']
                            ];
                            $color = $colors[$colorIndex];
                        @endphp

                        <div
                            x-data="{ hover: false }"
                            @mouseenter="hover = true"
                            @mouseleave="hover = false"
                            class="relative group"
                        >
                            <!-- Эффект свечения -->
                            <div
                                :class="hover ? 'opacity-100 scale-105' : 'opacity-0 scale-100'"
                                class="absolute -inset-1 bg-gradient-to-r {{ $color[0] }} {{ $color[1] }} rounded-2xl blur-xl transition-all duration-500"
                            ></div>

                            <!-- Карточка раздела -->
                            <div class="relative h-full p-6 bg-slate-900/60 backdrop-blur-sm rounded-xl border border-white/10
                                        hover:border-{{ explode('-', $color[2])[1] }}-500/50 transition-all duration-300
                                        transform group-hover:-translate-y-1">

                                <!-- Иконка -->
                                <div class="mb-5">
                                    <div class="inline-flex p-3 rounded-lg {{ $color[4] }} border {{ $color[3] }}
                                                group-hover:scale-110 transition-transform duration-300">
                                        <i data-lucide="{{ $section->icon ?? 'book-open' }}" class="w-6 h-6 {{ $color[2] }}"></i>
                                    </div>
                                </div>

                                <!-- Заголовок и описание -->
                                <h2 class="text-xl font-bold text-white mb-3 group-hover:{{ $color[2] }} transition-colors duration-200">
                                    {{ $section->title }}
                                </h2>
                                <p class="text-gray-400 text-sm mb-6 line-clamp-2">
                                    {{ $section->description }}
                                </p>

                                <!-- Прогресс -->
                                <div class="mb-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-400">Прогресс</span>
                                        <span class="text-sm font-bold {{ $color[2] }}">{{ round($progress) }}%</span>
                                    </div>
                                    <div class="relative h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-r {{ $color[0] }} {{ $color[1] }} opacity-20"></div>
                                        <div
                                            class="absolute top-0 left-0 h-full bg-gradient-to-r {{ $color[0] }} {{ $color[1] }}
                                                   rounded-full transition-all duration-700 ease-out"
                                            :style="`width: ${hover ? $progress + 5 : $progress}%`"
                                            x-bind:style="`width: ${hover ? {{ $progress }} + 5 : {{ $progress }}}%`"
                                        ></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-2">
                                        {{ $completedTasks }} из {{ $totalTasks }} заданий
                                    </div>
                                </div>

                                <!-- Кнопка -->
                                <button
                                    @click="openModal({{ $section->id }})"
                                    class="w-full py-3 {{ $color[4] }} {{ $color[3] }} rounded-lg font-medium
                                           group-hover:bg-gradient-to-r group-hover:{{ $color[0] }} group-hover:{{ $color[1] }}
                                           group-hover:text-white transition-all duration-300 flex items-center justify-center gap-2"
                                >
                                    <span :class="hover ? 'text-white' : '{{ $color[2] }}'" class="transition-colors duration-300">
                                        {{ $completedTasks > 0 ? 'Продолжить' : 'Начать обучение' }}
                                    </span>
                                    <i data-lucide="chevron-right"
                                       :class="hover ? 'translate-x-1 text-white' : '{{ $color[2] }}'"
                                       class="w-4 h-4 transition-all duration-300"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Сообщение если нет разделов -->
                @if($sections->isEmpty())
                    <div class="text-center py-16">
                        <div class="inline-flex p-6 rounded-2xl bg-slate-900/50 border border-white/10 mb-6">
                            <i data-lucide="folder-x" class="w-16 h-16 text-gray-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Разделы не найдены</h3>
                        <p class="text-gray-400 max-w-md mx-auto">
                            Администратор еще не добавил учебные материалы
                        </p>
                    </div>
                @endif
            </div>
        </main>

        <!-- MODAL -->
        <div
            x-show="showModal"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="closeModal()"
        >
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="closeModal()"></div>

            <!-- Модальное окно -->
            <div class="relative w-full max-w-2xl max-h-[85vh] overflow-hidden bg-gradient-to-br from-slate-900 to-gray-900
                        rounded-2xl border border-white/10 shadow-2xl shadow-cyan-500/10">

                <!-- Заголовок с градиентом -->
                <div class="relative p-6 bg-gradient-to-r from-slate-800 to-slate-900 border-b border-white/10">
                    <!-- Градиентная полоса сверху -->
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-purple-500"></div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 rounded-lg bg-cyan-500/10 border border-cyan-500/30">
                                <i data-lucide="list-checks" class="w-6 h-6 text-cyan-400"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">Задания раздела</h3>
                                <p class="text-gray-400 text-sm" x-text="tasks.length + ' заданий'"></p>
                            </div>
                        </div>

                        <button @click="closeModal()"
                                class="p-2.5 rounded-lg text-gray-400 hover:text-white hover:bg-white/10
                                       transition-all duration-200 group">
                            <i data-lucide="x" class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300"></i>
                        </button>
                    </div>
                </div>

                <!-- Контент -->
                <div class="overflow-y-auto max-h-[calc(85vh-120px)] modal-scroll">
                    <div class="p-6">
                        <template x-if="tasks.length === 0">
                            <div class="text-center py-12">
                                <div class="inline-flex p-6 rounded-2xl bg-slate-800/50 border border-white/10 mb-6">
                                    <i data-lucide="file-question" class="w-12 h-12 text-gray-600"></i>
                                </div>
                                <h4 class="text-xl font-bold text-white mb-2">Задания не найдены</h4>
                                <p class="text-gray-400">В этом разделе пока нет заданий</p>
                            </div>
                        </template>

                        <template x-for="(task, index) in tasks" :key="task.id">
                            <div class="group mb-4 last:mb-0">
                                <div class="relative p-5 rounded-xl bg-slate-800/40 border border-white/10
                                            hover:border-cyan-500/30 hover:bg-slate-800/60
                                            transition-all duration-300 transform hover:-translate-y-0.5">

                                    <!-- Номер задания -->
                                    <div class="absolute -left-3 -top-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500
                                                    flex items-center justify-center text-white font-bold text-sm">
                                            <span x-text="index + 1"></span>
                                        </div>
                                    </div>

                                    <div class="flex items-start justify-between gap-4 pl-4">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-white text-lg mb-2 group-hover:text-cyan-300
                                                       transition-colors duration-200" x-text="task.title"></h4>
                                            <p class="text-gray-400 text-sm mb-4 line-clamp-2" x-text="task.description"></p>

                                            <!-- Информация о задании -->
                                            <div class="flex flex-wrap gap-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="p-1.5 rounded bg-slate-900/50">
                                                        <i data-lucide="trending-up" class="w-4 h-4 text-blue-400"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-500">Сложность</div>
                                                        <div class="text-sm font-medium text-white" x-text="task.difficulty"></div>
                                                    </div>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <div class="p-1.5 rounded bg-slate-900/50">
                                                        <i data-lucide="star" class="w-4 h-4 text-yellow-400"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-500">Баллы</div>
                                                        <div class="text-sm font-medium text-white" x-text="task.points"></div>
                                                    </div>
                                                </div>

                                                <div x-show="task.completed" class="flex items-center gap-2">
                                                    <div class="p-1.5 rounded bg-emerald-500/10">
                                                        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs text-gray-500">Статус</div>
                                                        <div class="text-sm font-medium text-emerald-400">Выполнено</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Кнопка перехода -->
                                        <button @click="goToTask(task.id)"
                                                class="px-5 py-2.5 bg-gradient-to-r from-cyan-500/10 to-cyan-600/10
                                                       text-cyan-400 border border-cyan-500/30 rounded-lg font-medium
                                                       hover:bg-gradient-to-r hover:from-cyan-500 hover:to-cyan-600
                                                       hover:text-white hover:shadow-lg hover:shadow-cyan-500/20
                                                       transition-all duration-300 flex items-center gap-2 whitespace-nowrap
                                                       group-hover:scale-105">
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                            Перейти
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Футер модалки -->
                <div class="p-6 border-t border-white/10 bg-slate-900/50">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-400">
                            <i data-lucide="info" class="w-4 h-4 inline mr-2"></i>
                            Выберите задание для начала
                        </div>
                        <button @click="closeModal()"
                                class="px-4 py-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-lg
                                       transition-all duration-200">
                            Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="pt-12 pb-8 px-4 sm:px-6 border-t border-white/10">
            <div class="container mx-auto max-w-6xl">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <!-- Лого -->
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield" class="w-6 h-6 text-cyan-400"></i>
                        <span class="text-lg font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                            CyberSafe Trainer
                        </span>
                    </div>

                    <!-- Навигация -->
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ url('/') }}"
                           class="text-sm text-gray-400 hover:text-cyan-400 transition-colors">
                            Главная
                        </a>
                        <a href="{{ route('sections.index') }}"
                           class="text-sm text-cyan-400 font-medium">
                            Разделы
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}"
                               class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">
                                Кабинет
                            </a>
                        @endauth
                    </div>

                    <!-- Копирайт -->
                    <div class="text-sm text-gray-500">
                        Студенческий проект · 2025
                    </div>
                </div>

                <!-- Декоративная линия -->
                <div class="mt-8 pt-8 border-t border-white/5 text-center">
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center gap-2 text-gray-500 hover:text-white transition-colors text-sm">
                        <i data-lucide="home" class="w-4 h-4"></i>
                        На главную страницу
                    </a>
                </div>
            </div>
        </footer>
    </div>

    @push('styles')
        <style>
            @keyframes float {
                0%, 100% {
                    transform: translateY(0) rotate(0deg);
                }
                50% {
                    transform: translateY(-15px) rotate(180deg);
                }
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .animate-gradient {
                background-size: 200% 200%;
                animation: gradient 3s ease infinite;
            }

            [x-cloak] {
                display: none !important;
            }

            /* Кастомный скроллбар */
            .modal-scroll {
                scrollbar-width: thin;
                scrollbar-color: #3b82f6 #1e293b;
            }

            .modal-scroll::-webkit-scrollbar {
                width: 8px;
            }

            .modal-scroll::-webkit-scrollbar-track {
                background: rgba(30, 41, 59, 0.5);
                border-radius: 4px;
            }

            .modal-scroll::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #06b6d4, #3b82f6);
                border-radius: 4px;
            }

            .modal-scroll::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #0891b2, #2563eb);
            }

            /* Обрезание текста */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Эффект для body при открытой модалке */
            body.modal-open {
                overflow: hidden;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('modalSection', () => ({
                    openModal(sectionId) {
                        // Ваш код открытия модалки
                    }
                }));
            });
        </script>
    @endpush
@endsection
