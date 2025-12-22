@extends('layouts.app')

@section('content')
    <div
        x-data="{
            showPassword: false,
            floatingElements: [],
            init() {
                // Создаем плавающие элементы
                this.createFloatingElements();

                // Инициализация иконок
                this.$nextTick(() => {
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                });
            },
            createFloatingElements() {
                const elements = [];
                const colors = ['from-cyan-400/10', 'from-blue-500/10', 'from-purple-500/10'];

                for (let i = 0; i < 6; i++) {
                    elements.push({
                        id: i,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        size: Math.random() * 25 + 15,
                        top: Math.random() * 100,
                        left: Math.random() * 100,
                        speed: Math.random() * 2 + 1
                    });
                }
                this.floatingElements = elements;
            },
            togglePassword() {
                this.showPassword = !this.showPassword;
                document.getElementById('password').type = this.showPassword ? 'text' : 'password';
            }
        }"
        class="min-h-screen bg-gradient-to-br from-slate-900 via-gray-900 to-slate-900"
    >

        <!-- Плавающие элементы -->
        <template x-for="element in floatingElements" :key="element.id">
            <div
                :class="'absolute rounded-full bg-gradient-to-r ' + element.color + ' to-transparent'"
                :style="`
                    top: ${element.top}%;
                    left: ${element.left}%;
                    width: ${element.size}px;
                    height: ${element.size}px;
                    animation: float ${3 + element.speed}s ease-in-out infinite;
                    opacity: 0.1;
                `"
            ></div>
        </template>

        <!-- HEADER -->
        <header class="fixed top-0 w-full z-50 bg-slate-900/80 backdrop-blur-md border-b border-white/10">
            <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <i data-lucide="shield" class="w-8 h-8 text-cyan-400 group-hover:scale-110 transition-transform"></i>
                    <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                        CyberSafe Trainer
                    </span>
                </a>

                <a href="{{ route('register') }}"
                   class="px-4 py-2 rounded-lg border border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10 transition-all">
                    Регистрация
                </a>
            </nav>
        </header>

        <!-- MAIN CONTENT -->
        <main class="min-h-screen flex items-center justify-center px-4 py-20">
            <div class="w-full max-w-md">
                <!-- Карточка формы -->
                <div class="relative group">
                    <!-- Эффект свечения -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>

                    <div class="relative p-8 bg-slate-800/70 backdrop-blur-sm rounded-xl border border-white/10">
                        <!-- Заголовок -->
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center gap-3 mb-4">
                                <i data-lucide="log-in" class="w-10 h-10 text-cyan-400"></i>
                                <h1 class="text-3xl font-bold text-white">Вход в систему</h1>
                            </div>
                            <p class="text-gray-400">Войдите в свой аккаунт</p>
                        </div>

                        <!-- Сообщения об ошибках -->
                        @if($errors->any())
                            <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/30">
                                <div class="flex items-center gap-2 text-red-400">
                                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                                    <p class="font-medium">Неверные данные</p>
                                </div>
                                <p class="mt-2 text-sm text-red-300">Проверьте email и пароль</p>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST" class="space-y-5">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label class="block mb-2 text-gray-300">
                                    <i data-lucide="mail" class="w-4 h-4 inline mr-2 text-cyan-400"></i>
                                    Email
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="ваш@email.com"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-900/50 text-white border border-white/10
                                           focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500/20 transition"
                                >
                            </div>

                            <!-- Пароль -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-gray-300">
                                        <i data-lucide="lock" class="w-4 h-4 inline mr-2 text-blue-400"></i>
                                        Пароль
                                    </label>
                                    <button
                                        type="button"
                                        @click="togglePassword()"
                                        class="text-sm text-gray-400 hover:text-blue-400 transition"
                                    >
                                        <i :data-lucide="showPassword ? 'eye-off' : 'eye'" class="w-4 h-4 inline"></i>
                                        <span x-text="showPassword ? 'Скрыть' : 'Показать'" class="ml-1"></span>
                                    </button>
                                </div>
                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required
                                    placeholder="••••••••"
                                    class="w-full px-4 py-3 rounded-lg bg-slate-900/50 text-white border border-white/10
                                           focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500/20 transition"
                                >
                            </div>

                            <!-- Запомнить меня -->
                            <div class="flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    class="rounded border-white/20 bg-slate-900/50 text-cyan-500"
                                >
                                <label for="remember" class="text-gray-400 text-sm">
                                    Запомнить меня
                                </label>
                            </div>

                            <!-- Кнопка входа -->
                            <button
                                type="submit"
                                class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-lg
                                       hover:shadow-lg hover:shadow-cyan-500/20 transition-all mt-2"
                            >
                                <div class="flex items-center justify-center gap-2">
                                    <i data-lucide="log-in" class="w-5 h-5"></i>
                                    Войти в аккаунт
                                </div>
                            </button>
                        </form>

                        <!-- Ссылки -->
                        <div class="mt-6 pt-6 border-t border-white/10">
                            <!-- Регистрация -->
                            <div class="text-center mb-4">
                                <p class="text-gray-400">
                                    Нет аккаунта?
                                    <a href="{{ route('register') }}" class="text-cyan-400 hover:text-cyan-300 transition-colors font-medium">
                                        Зарегистрироваться
                                    </a>
                                </p>
                            </div>

                            <!-- На главную -->
                            <div class="text-center">
                                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm">
                                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                    Вернуться на главную
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Простая статистика -->
                <div class="mt-6 p-4 rounded-lg bg-slate-800/40 border border-white/10 text-center">
                    <div class="flex items-center justify-center gap-4">
                        <div>
                            <div class="text-cyan-400 font-bold">{{ $totalUsers ?? '100+' }}</div>
                            <div class="text-gray-400 text-sm">студентов</div>
                        </div>
                        <div class="h-8 w-px bg-white/10"></div>
                        <div>
                            <div class="text-blue-400 font-bold">{{ $totalCompletedTasks ?? '500+' }}</div>
                            <div class="text-gray-400 text-sm">заданий пройдено</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="py-6 text-center border-t border-white/10">
            <div class="container mx-auto px-4">
                <p class="text-gray-500 text-sm">
                    <i data-lucide="graduation-cap" class="w-4 h-4 inline mr-2"></i>
                    Студенческий проект · 2025
                </p>
            </div>
        </footer>
    </div>

    @push('styles')
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(180deg); }
            }

            input:-webkit-autofill {
                -webkit-text-fill-color: white;
                -webkit-box-shadow: 0 0 0px 1000px rgba(30, 41, 59, 0.7) inset;
                transition: background-color 5000s ease-in-out 0s;
            }
        </style>
    @endpush
@endsection
