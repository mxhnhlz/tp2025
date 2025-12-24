@extends('layouts.app')

@section('content')
    <div
        x-data="{
            isMenuOpen: false,
            scrolled: false,
            activeSection: 0,
            sectionsCount: 4,
            floatingElements: [],
            mouseX: 0,
            mouseY: 0,
            init() {
                // Параллакс эффект
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 50;

                    // Параллакс для фона
                    const scrolled = window.pageYOffset;
                    const parallax = document.querySelector('.parallax-bg');
                    if (parallax) {
                        parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
                    }
                });

                // Автопереключение секций
                setInterval(() => this.activeSection = (this.activeSection + 1) % this.sectionsCount, 3000);

                // Следим за движением мыши
                document.addEventListener('mousemove', (e) => {
                    this.mouseX = e.clientX / window.innerWidth;
                    this.mouseY = e.clientY / window.innerHeight;
                });

                // Создаем плавающие элементы
                this.createFloatingElements();

                // Инициализация Lucide иконок после рендера Alpine
                this.$nextTick(() => {
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                });
            },
            createFloatingElements() {
                const elements = [];
                const shapes = ['circle', 'square', 'triangle', 'hexagon'];
                const colors = ['from-cyan-400/20', 'from-purple-500/20', 'from-blue-500/20', 'from-emerald-500/20'];

                for (let i = 0; i < 15; i++) {
                    elements.push({
                        id: i,
                        shape: shapes[Math.floor(Math.random() * shapes.length)],
                        color: colors[Math.floor(Math.random() * colors.length)],
                        size: Math.random() * 40 + 20,
                        top: Math.random() * 100,
                        left: Math.random() * 100,
                        speed: Math.random() * 2 + 0.5,
                        direction: Math.random() > 0.5 ? 1 : -1
                    });
                }
                this.floatingElements = elements;
            },
            getTransform(index) {
                const x = Math.sin(Date.now() / 1000 + index) * 10 * this.mouseX;
                const y = Math.cos(Date.now() / 1000 + index) * 10 * this.mouseY;
                return `translate(${x}px, ${y}px)`;
            }
        }"
        class="min-h-screen overflow-hidden bg-gradient-to-br from-slate-950 via-gray-900 to-slate-950"
        style="background-image: radial-gradient(circle at 20% 80%, rgba(56, 189, 248, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.1) 0%, transparent 50%);"
    >
        <!-- Плавающие элементы фона -->
        <template x-for="element in floatingElements" :key="element.id">
            <div
                :class="[
                    'absolute rounded-full bg-gradient-to-r ' + element.color + ' to-transparent',
                    element.shape === 'square' && 'rounded-lg',
                    element.shape === 'triangle' && 'clip-path-triangle'
                ]"
                :style="`
                    top: ${element.top}%;
                    left: ${element.left}%;
                    width: ${element.size}px;
                    height: ${element.size}px;
                    animation: float ${3 + element.speed}s ease-in-out infinite;
                    animation-delay: ${element.id * 0.2}s;
                    transform: ${getTransform(element.id)};
                    opacity: ${0.2 + Math.random() * 0.3};
                `"
            ></div>
        </template>

        <!-- Параллакс фон -->
        <div class="parallax-bg fixed inset-0 -z-10 opacity-30">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
    </div>

    <!-- HEADER -->
    <header
        x-data="{
        isMenuOpen: false,
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
            });
        }
    }"
        :class="scrolled || isMenuOpen ? 'bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-cyan-500/10' : 'bg-slate-900/20 backdrop-blur-md'"
        class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-white/5"
    >
        <nav class="container mx-auto px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
            <!-- Логотип -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full blur opacity-70 group-hover:opacity-100 transition-opacity"></div>
                    <i data-lucide="shield" class="w-7 h-7 sm:w-8 sm:h-8 text-cyan-400 relative z-10 group-hover:scale-110 transition-transform"></i>
                </div>
                <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent bg-size-200 animate-gradient">
                CyberSafe Trainer
            </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex gap-4 sm:gap-6 items-center">
                <a href="#"
                   class="relative px-3 sm:px-4 py-2 text-white/80 hover:text-cyan-400 transition-all group">
                    <span class="relative z-10 text-sm sm:text-base">О проекте</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/0 via-cyan-500/10 to-cyan-500/0 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                </a>
                <a href="{{ route('sections.index') }}"
                   class="relative px-3 sm:px-4 py-2 text-white/80 hover:text-cyan-400 transition-all group">
                    <span class="relative z-10 text-sm sm:text-base">Разделы</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/10 to-blue-500/0 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                </a>
                <a href="#stats"
                   class="relative px-3 sm:px-4 py-2 text-white/80 hover:text-cyan-400 transition-all group">
                    <span class="relative z-10 text-sm sm:text-base">Статистика</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500/0 via-purple-500/10 to-purple-500/0 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                </a>

                <!-- Аватар профиля (для авторизованных) -->
                @auth
                    <div class="relative group ml-2 sm:ml-4">
                        <!-- Аватар пользователя -->
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm sm:text-lg cursor-pointer border-2 border-transparent group-hover:border-cyan-400/50 transition-all duration-300">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <!-- Выпадающее меню профиля -->
                        <div class="absolute right-0 mt-2 w-56 bg-slate-800/90 backdrop-blur-xl rounded-xl shadow-2xl border border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <!-- Информация о пользователе -->
                            <div class="p-4 border-b border-white/10">
                                <p class="text-white font-semibold truncate text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-gray-400 text-xs truncate">{{ auth()->user()->email }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="px-2 py-1 bg-emerald-500/10 rounded text-xs text-emerald-400 border border-emerald-500/20">
                                        Уровень {{ auth()->user()->level }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ auth()->user()->xp ?? 0 }} XP
                                    </div>
                                </div>
                            </div>

                            <!-- Ссылки профиля -->
                            <div class="p-2">
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all duration-200">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                    <span class="text-sm">Личный кабинет</span>
                                </a>
                                <a href="{{ route('achievements.index') }}"
                                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-gray-300 hover:text-yellow-400 hover:bg-white/5 transition-all duration-200">
                                    <i data-lucide="trophy" class="w-4 h-4"></i>
                                    <span class="text-sm">Достижения</span>
                                </a>
                                <a href="{{ route('sections.index') }}"
                                   class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-gray-300 hover:text-blue-400 hover:bg-white/5 transition-all duration-200">
                                    <i data-lucide="book-open" class="w-4 h-4"></i>
                                    <span class="text-sm">Обучение</span>
                                </a>
                            </div>

                            <!-- Выход -->
                            <div class="p-2 border-t border-white/10">
                                <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        <span class="text-sm">Выйти из аккаунта</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Кнопка регистрации/входа для неавторизованных -->
                    <a href="{{ route('register') }}"
                       class="relative px-4 sm:px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-semibold text-white hover:shadow-lg hover:shadow-cyan-500/25 transition-all group overflow-hidden ml-2 sm:ml-4">
                        <span class="relative z-10 text-sm sm:text-base">Регистрация</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    </a>
                @endauth
            </div>

            <!-- Mobile button -->
            <button @click="isMenuOpen = !isMenuOpen" class="md:hidden relative w-10 h-10 group">
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative w-full h-full flex items-center justify-center">
                    <i x-show="!isMenuOpen" data-lucide="menu" class="w-6 h-6 text-white"></i>
                    <i x-show="isMenuOpen" data-lucide="x" class="w-6 h-6 text-white"></i>
                </div>
            </button>
        </nav>

        <!-- Mobile menu -->
        <div x-show="isMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden px-4 sm:px-6 pb-6 space-y-2 bg-slate-900/90 backdrop-blur-xl border-t border-white/10">

            <!-- Навигация -->
            <a href="#about"
               class="block px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 transition-all flex items-center gap-3">
                <i data-lucide="info" class="w-4 h-4 text-cyan-400"></i>
                О проекте
            </a>
            <a href="{{ route('sections.index') }}"
               class="block px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 transition-all flex items-center gap-3">
                <i data-lucide="folder-open" class="w-4 h-4 text-blue-400"></i>
                Разделы
            </a>
            <a href="#stats"
               class="block px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 transition-all flex items-center gap-3">
                <i data-lucide="bar-chart" class="w-4 h-4 text-purple-400"></i>
                Статистика
            </a>

            <!-- Профиль пользователя (если авторизован) -->
            @auth
                <div class="pt-3 border-t border-white/10">
                    <div class="px-4 py-3">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-gray-400 text-xs">{{ auth()->user()->email }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 bg-emerald-500/10 rounded text-xs text-emerald-400 border border-emerald-500/20">
                                    Уровень {{ auth()->user()->level }}
                                </span>
                                    <span class="text-xs text-gray-500">
                                    {{ auth()->user()->xp ?? 0 }} XP
                                </span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                <span class="text-sm">Личный кабинет</span>
                            </a>
                            <a href="{{ route('achievements.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-yellow-400 hover:bg-white/5 transition-all">
                                <i data-lucide="trophy" class="w-4 h-4"></i>
                                <span class="text-sm">Достижения</span>
                            </a>
                            <a href="{{ route('sections.index') }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-blue-400 hover:bg-white/5 transition-all">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                                <span class="text-sm">Обучение</span>
                            </a>
                        </div>

                        <div class="mt-3 pt-3 border-t border-white/10">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:shadow-lg hover:shadow-red-500/25 transition-all">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    <span class="text-sm">Выйти из аккаунта</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Кнопка регистрации для неавторизованных -->
                <div class="pt-3 border-t border-white/10">
                    <a href="{{ route('register') }}"
                       class="flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-600
                          text-white font-medium rounded-lg hover:shadow-lg hover:shadow-cyan-500/25 transition-all">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                        Войти / Регистрация
                    </a>
                </div>
            @endauth
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative min-h-screen flex items-center justify-center px-6 pt-16">
        <div class="container mx-auto text-center relative z-10">
            <!-- Анимированный заголовок -->
            <div class="mb-8">
                <h1 class="text-5xl md:text-8xl font-bold mb-6">
                        <span class="block mb-2">
                            <span class="bg-gradient-to-r from-cyan-400 via-blue-400 to-purple-500 bg-clip-text text-transparent bg-size-200 animate-gradient">
                                CyberSafe
                            </span>
                        </span>
                    <span class="block text-3xl md:text-5xl font-light text-white/80">
                            Интерактивный симулятор
                        </span>
                </h1>

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-cyan-500/20 to-purple-500/20 border border-cyan-500/30 mb-6">
                    <div class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></div>
                    <span class="text-cyan-300">Защитите себя в цифровом мире</span>
                </div>
            </div>

            <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-12 leading-relaxed">
                Освойте практические навыки кибербезопасности через интерактивные задания, симуляции атак и персонализированные сценарии. Станьте неуязвимым в цифровом пространстве.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                @auth
                    <a href="{{ route('sections.index') }}"
                       class="group relative px-10 py-4 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-1">
                            <span class="relative z-10 flex items-center gap-3">
                                Начать обучение
                                <i data-lucide="chevron-right" class="group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur opacity-30 group-hover:opacity-70 transition-opacity duration-300"></div>
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="group relative px-10 py-4 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-1">
                            <span class="relative z-10 flex items-center gap-3">
                                Начать бесплатно
                                <i data-lucide="sparkles" class="w-5 h-5"></i>
                            </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur opacity-30 group-hover:opacity-70 transition-opacity duration-300"></div>
                    </a>
                @endauth


            </div>

            <!-- Hero Stats -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                    <div class="text-3xl font-bold text-cyan-400 mb-2" x-data="{ count: 0, target: {{ $totalUsers }} }" x-init="() => { const interval = setInterval(() => { if (count < target) count++; else clearInterval(interval); }, 20) }" x-text="Math.floor(count)">0</div>
                    <div class="text-gray-400">Активных пользователей</div>
                </div>
                <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                    <div class="text-3xl font-bold text-purple-400 mb-2">{{ \App\Models\Section::count() }}+</div>
                    <div class="text-gray-400">Разделов обучения</div>
                </div>
                <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                    <div class="text-3xl font-bold text-emerald-400 mb-2" x-data="{ count: 0, target: {{ $totalCompletedTasks }} }" x-init="() => { const interval = setInterval(() => { if (count < target) count++; else clearInterval(interval); }, 10) }" x-text="Math.floor(count)">0</div>
                    <div class="text-gray-400">Выполнено заданий</div>
                </div>
                <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all">
                    <div class="text-3xl font-bold text-orange-400 mb-2">24/7</div>
                    <div class="text-gray-400">Доступ к платформе</div>
                </div>
            </div>
        </div>

        <!-- Анимированные иконки безопасности -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <i data-lucide="shield" class="absolute top-1/4 left-10 w-16 h-16 text-cyan-500/20 animate-float-slow"></i>
            <i data-lucide="lock" class="absolute top-1/3 right-20 w-12 h-12 text-purple-500/20 animate-float"></i>
            <i data-lucide="key" class="absolute bottom-1/4 left-20 w-14 h-14 text-blue-500/20 animate-float-slower"></i>
            <i data-lucide="eye-off" class="absolute bottom-1/3 right-10 w-10 h-10 text-emerald-500/20 animate-float"></i>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section id="features" class="py-32 px-6 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-900/50 to-slate-950"></div>
        <div class="container mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl font-bold mb-6 text-white">
                        <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                            Уникальный подход
                        </span>
                    к обучению
                </h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Мы совмещаем теорию с практикой через интерактивные симуляции реальных кибератак
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-20">
                <!-- Наши преимущества -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative p-8 bg-slate-900/70 backdrop-blur-xl rounded-2xl border border-white/10 group-hover:border-cyan-500/30 transition-all duration-300">
                        <div class="inline-flex items-center gap-3 mb-6">
                            <div class="p-3 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600">
                                <i data-lucide="check-circle" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Наши инновации</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="zap" class="w-5 h-5 text-cyan-400 mt-1 group-hover/item:animate-pulse"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-cyan-300">Интерактивные симуляции</strong> — отработка навыков на реалистичных сценариях
                                    </span>
                            </li>
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="smartphone" class="w-5 h-5 text-blue-400 mt-1 group-hover/item:animate-bounce"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-blue-300">Адаптивное обучение</strong> — программа подстраивается под ваш уровень
                                    </span>
                            </li>
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="trending-up" class="w-5 h-5 text-emerald-400 mt-1 group-hover/item:rotate-12 transition-transform"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-emerald-300">Детальная аналитика</strong> — отслеживание прогресса
                                    </span>
                            </li>
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="gamepad-2" class="w-5 h-5 text-purple-400 mt-1 group-hover/item:scale-110 transition-transform"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-purple-300">Геймификация</strong> — достижения
                                    </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Проблемы других -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-red-500 to-orange-500 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative p-8 bg-slate-900/70 backdrop-blur-xl rounded-2xl border border-white/10 group-hover:border-red-500/30 transition-all duration-300">
                        <div class="inline-flex items-center gap-3 mb-6">
                            <div class="p-3 rounded-xl bg-gradient-to-br from-red-500 to-orange-600">
                                <i data-lucide="x-circle" class="w-6 h-6 text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Ограничения других платформ</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="book" class="w-5 h-5 text-red-400 mt-1 group-hover/item:shake"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-red-300">Только теория</strong> — отсутствие практических заданий
                                    </span>
                            </li>
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="user-x" class="w-5 h-5 text-orange-400 mt-1 group-hover/item:animate-pulse"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-orange-300">Без персонализации</strong> — единая программа для всех
                                    </span>
                            </li>
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="clock" class="w-5 h-5 text-yellow-400 mt-1 group-hover/item:rotate-45 transition-transform"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-yellow-300">Устаревший контент</strong> — информация не обновляется годами
                                    </span>
                            </li>
                            <li class="flex items-start gap-3 group/item">
                                <i data-lucide="monitor-off" class="w-5 h-5 text-pink-400 mt-1 group-hover/item:scale-110 transition-transform"></i>
                                <span class="text-gray-300 group-hover/item:text-white transition-colors">
                                        <strong class="text-pink-300">Нет мобильной версии</strong> — обучение только с компьютера
                                    </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Интерактивный демо -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 via-purple-500 to-blue-500 rounded-3xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
                <div class="relative p-1 rounded-2xl bg-slate-900/50 backdrop-blur-xl">
                    <div class="rounded-xl overflow-hidden border border-white/10">
                        <div class="p-6 bg-gradient-to-r from-slate-900 to-slate-800">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-white">Интерактивная демонстрация</h3>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="p-4 rounded-lg bg-slate-800/50 border border-slate-700 hover:border-cyan-500/50 transition-colors cursor-pointer">
                                    <div class="text-cyan-400 font-bold mb-2">Симуляция фишинга</div>
                                    <div class="text-sm text-gray-400">Определите поддельное письмо</div>
                                </div>
                                <div class="p-4 rounded-lg bg-slate-800/50 border border-slate-700 hover:border-blue-500/50 transition-colors cursor-pointer">
                                    <div class="text-blue-400 font-bold mb-2">Проверка паролей</div>
                                    <div class="text-sm text-gray-400">Оцените надежность пароля</div>
                                </div>
                                <div class="p-4 rounded-lg bg-slate-800/50 border border-slate-700 hover:border-purple-500/50 transition-colors cursor-pointer">
                                    <div class="text-purple-400 font-bold mb-2">Wi-Fi безопасность</div>
                                    <div class="text-sm text-gray-400">Настройте защищенное соединение</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INTERACTIVE SECTIONS -->
    <section id="sections" class="py-32 px-6 bg-gradient-to-b from-slate-950 to-gray-900">
        <div class="container mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl font-bold mb-6 text-white">
                        <span class="bg-gradient-to-r from-cyan-400 to-purple-500 bg-clip-text text-transparent">
                            Интерактивные
                        </span>
                    разделы
                </h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Практикуйтесь на реальных сценариях кибератак с мгновенной обратной связью
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                @php
                    $allSections = \App\Models\Section::all();
                    $sections = $allSections->take(4);
                    $colors = ['cyan', 'blue', 'purple', 'emerald'];
                @endphp

                @foreach($sections as $index => $section)
                    <div
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="relative group"
                    >
                        <!-- Эффект свечения -->
                        <div
                            :class="activeSection === {{ $index }} ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'"
                            class="absolute -inset-1 bg-gradient-to-r from-{{ $colors[$index] }}-500 to-{{ $colors[$index] }}-600 rounded-3xl blur transition-all duration-500"
                        ></div>

                        <a
                            href="{{ route('sections.index') }}"
                            :class="[
                                    activeSection === {{ $index }} ? 'scale-105 border-{{ $colors[$index] }}-400/50' : '',
                                    hover ? 'border-{{ $colors[$index] }}-400/30 scale-[1.02]' : ''
                                ]"
                            class="relative p-8 bg-slate-900/70 backdrop-blur-xl rounded-2xl border border-white/10 transition-all duration-300 flex flex-col h-full group"
                        >
                            <!-- Иконка с анимацией -->
                            <div class="mb-6">
                                <div class="inline-flex p-4 rounded-xl bg-gradient-to-br from-{{ $colors[$index] }}-500/20 to-{{ $colors[$index] }}-600/20 border border-{{ $colors[$index] }}-400/30">
                                    <i data-lucide="{{ $section->icon ?? 'lock' }}"
                                       :class="[
                                               activeSection === {{ $index }} ? 'animate-pulse' : '',
                                               hover ? 'scale-110' : ''
                                           ]"
                                       class="w-8 h-8 text-{{ $colors[$index] }}-400 transition-transform duration-300"></i>
                                </div>
                            </div>

                            <!-- Заголовок и описание -->
                            <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-{{ $colors[$index] }}-300 transition-colors">
                                {{ $section->title }}
                            </h3>
                            <p class="text-gray-400 mb-6 flex-grow">
                                {{ $section->description }}
                            </p>

                            <!-- Прогресс и кнопка -->
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center gap-3">
                                    <span class="text-{{ $colors[$index] }}-400 font-bold">Бесплатно</span>
                                    <span class="text-gray-500">•</span>
                                    <div class="flex items-center gap-1">
                                        <i data-lucide="clock" class="w-4 h-4 text-gray-500"></i>
                                        <span class="text-gray-500 text-sm">30 мин</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-{{ $colors[$index] }}-400 group-hover:gap-3 transition-all">
                                    <span class="font-semibold">Начать</span>
                                    <i data-lucide="chevron-right"
                                       :class="hover ? 'translate-x-1' : ''"
                                       class="w-5 h-5 transition-transform"></i>
                                </div>
                            </div>

                            <!-- Индикатор активности -->
                            <div
                                :class="activeSection === {{ $index }} ? 'w-full' : 'w-0'"
                                class="absolute bottom-0 left-0 h-1 bg-gradient-to-r from-{{ $colors[$index] }}-400 to-{{ $colors[$index] }}-600 rounded-b-2xl transition-all duration-1000"
                            ></div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($allSections->count() > 4)
                <div class="text-center mt-16">
                    <a href="{{ route('sections.index') }}"
                       class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/10 transition-all duration-300 border border-white/10 hover:border-cyan-500/30">
                        <span>Открыть все разделы</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- STATISTICS SECTION -->
    <section id="stats" class="py-32 px-6 relative overflow-hidden">
        <!-- Анимированный фон -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-purple-500/5 to-blue-500/5"></div>
            <div class="absolute top-0 left-0 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        </div>

        <div class="container mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-6xl font-bold mb-6 text-white">
                        <span class="bg-gradient-to-r from-emerald-400 to-cyan-500 bg-clip-text text-transparent">
                            Живая статистика
                        </span>
                    платформы
                </h2>
                <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                    Присоединяйтесь к сообществу из {{ $totalUsers }}+ пользователей, которые уже улучшили свою цифровую безопасность
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                <!-- Статистика 1 -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-3xl blur opacity-0 group-hover:opacity-30 transition duration-500"></div>
                    <div class="relative p-8 bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-white/10 group-hover:border-cyan-500/50 transition-all duration-300 text-center">
                        <div class="text-5xl font-bold text-cyan-400 mb-4"
                             x-data="{ count: 0, target: {{ $totalUsers }} }"
                             x-init="() => {
                                     let interval = setInterval(() => {
                                         if (count < target) count += Math.ceil(target / 100);
                                         else { count = target; clearInterval(interval); }
                                     }, 20)
                                 }"
                             x-text="Math.floor(count).toLocaleString()">
                            0
                        </div>
                        <div class="text-gray-300 font-semibold">Зарегистрированных пользователей</div>
                        <div class="mt-4 h-2 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"
                                 :style="`width: ${Math.min(100, (count / {{ max($totalUsers, 1) }}) * 100)}%`"
                                 x-data="{ count: 0, target: {{ $totalUsers }} }"
                                 x-init="() => {
                                         let interval = setInterval(() => {
                                             if (count < target) count += target / 100;
                                             else { count = target; clearInterval(interval); }
                                         }, 20)
                                     }">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Статистика 2 -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-green-500 rounded-3xl blur opacity-0 group-hover:opacity-30 transition duration-500"></div>
                    <div class="relative p-8 bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-white/10 group-hover:border-emerald-500/50 transition-all duration-300 text-center">
                        <div class="text-5xl font-bold text-emerald-400 mb-4"
                             x-data="{ count: 0, target: {{ $totalCompletedTasks }} }"
                             x-init="() => {
                                     let interval = setInterval(() => {
                                         if (count < target) count += Math.ceil(target / 100);
                                         else { count = target; clearInterval(interval); }
                                     }, 10)
                                 }"
                             x-text="Math.floor(count).toLocaleString()">
                            0
                        </div>
                        <div class="text-gray-300 font-semibold">Пройдено заданий</div>
                        <div class="mt-4 h-2 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-green-500 rounded-full"
                                 :style="`width: ${Math.min(100, (count / {{ max($totalCompletedTasks, 1) }}) * 100)}%`"
                                 x-data="{ count: 0, target: {{ $totalCompletedTasks }} }"
                                 x-init="() => {
                                         let interval = setInterval(() => {
                                             if (count < target) count += target / 100;
                                             else { count = target; clearInterval(interval); }
                                         }, 10)
                                     }">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Статистика 3 -->
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-3xl blur opacity-0 group-hover:opacity-30 transition duration-500"></div>
                    <div class="relative p-8 bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-white/10 group-hover:border-purple-500/50 transition-all duration-300 text-center">
                        <div class="text-5xl font-bold text-purple-400 mb-4">
                            {{ \App\Models\Section::count() }}+
                        </div>
                        <div class="text-gray-300 font-semibold">Интерактивных разделов</div>
                        <div class="mt-4 flex justify-center gap-1">
                            @foreach(['shield', 'lock', 'key', 'eye-off', 'fingerprint'] as $icon)
                                <div class="p-2 bg-purple-500/10 rounded-lg">
                                    <i data-lucide="{{ $icon }}" class="w-4 h-4 text-purple-400"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>


            </div>

            <!-- CTA в конце -->
            <div class="mt-20 text-center">
                <div class="inline-block p-1 rounded-2xl bg-gradient-to-r from-cyan-500 via-blue-500 to-purple-500 animate-gradient-x">
                    <div class="bg-slate-900 rounded-xl p-8">
                        <h3 class="text-3xl font-bold text-white mb-4">Готовы начать?</h3>
                        <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
                            Присоединяйтесь к пользователям, которые уже защитили себя в цифровом мире!
                        </p>
                        @auth
                            <a href="{{ route('sections.index') }}"
                               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/30 transition-all transform hover:-translate-y-1">
                                <span>Продолжить обучение</span>
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/30 transition-all transform hover:-translate-y-1">
                                <span>Начать бесплатно</span>
                                <i data-lucide="sparkles" class="w-5 h-5"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="relative py-12 px-6 border-t border-white/10">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <!-- Логотип -->
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur opacity-70"></div>
                        <i data-lucide="shield" class="w-10 h-10 text-cyan-400 relative z-10"></i>
                    </div>
                    <div>
                        <div class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                            CyberSafe Trainer
                        </div>
                        <div class="text-gray-500 text-sm">Защита в цифровую эпоху</div>
                    </div>
                </div>

                <!-- Навигация -->
                <div class="flex flex-wrap gap-6 justify-center">
                    <a href="#" class="text-gray-400 hover:text-cyan-400 transition-colors">О проекте</a>
                    <a href="{{ route('sections.index') }}" class="text-gray-400 hover:text-blue-400 transition-colors">Разделы</a>
                    <a href="#stats" class="text-gray-400 hover:text-purple-400 transition-colors">Статистика</a>

                </div>


            </div>

            <!-- Копирайт -->
            <div class="mt-12 pt-8 border-t border-white/10 text-center">
                <p class="text-gray-500">
                    <span class="block mt-1 text-sm text-gray-600">
                            Сделано с <i data-lucide="heart" class="inline w-4 h-4 text-red-500 fill-red-500"></i> для безопасного интернета
                        </span>
                </p>
            </div>
        </div>
    </footer>
    </div>

    @push('styles')
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(180deg); }
            }

            @keyframes float-slow {
                0%, 100% { transform: translateY(0) scale(1); }
                50% { transform: translateY(-30px) scale(1.05); }
            }

            @keyframes float-slower {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(10deg); }
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .animate-float-slow {
                animation: float-slow 8s ease-in-out infinite;
            }

            .animate-float-slower {
                animation: float-slower 10s ease-in-out infinite;
            }

            .animate-gradient {
                background-size: 200% 200%;
                animation: gradient 3s ease infinite;
            }

            .animate-gradient-x {
                background-size: 200% 200%;
                animation: gradient 3s ease infinite;
            }

            .bg-size-200 {
                background-size: 200% 200%;
            }

            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
                20%, 40%, 60%, 80% { transform: translateX(2px); }
            }

            .group-hover\:item\:shake:hover {
                animation: shake 0.5s ease-in-out;
            }

            .clip-path-triangle {
                clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            }

            /* Стили для скроллбара */
            ::-webkit-scrollbar {
                width: 10px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(15, 23, 42, 0.5);
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #06b6d4, #3b82f6);
                border-radius: 5px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #0891b2, #2563eb);
            }

            /* Параллакс эффекты */
            .parallax-bg {
                will-change: transform;
            }

            /* Эффекты свечения */
            .glow {
                box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);
            }
        </style>
    @endpush
@endsection
