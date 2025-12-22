@extends('layouts.app')

@section('content')
    <div
        x-data="{
            isMenuOpen: false,
            scrolled: false,
            showPassword: false,
            showConfirmPassword: false,
            passwordStrength: 0,
            floatingElements: [],
            mouseX: 0,
            mouseY: 0,
            progressValue: 0,
            formValid: false,
            init() {
                // Следим за скроллом
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 50;
                });

                // Следим за движением мыши
                document.addEventListener('mousemove', (e) => {
                    this.mouseX = e.clientX / window.innerWidth;
                    this.mouseY = e.clientY / window.innerHeight;
                });

                // Создаем плавающие элементы
                this.createFloatingElements();

                // Инициализация Lucide иконок
                this.$nextTick(() => {
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                });

                // Проверяем валидность формы каждые 500мс
                setInterval(() => {
                    const name = document.getElementById('name')?.value;
                    const email = document.getElementById('email')?.value;
                    const password = document.getElementById('password')?.value;
                    const confirm = document.getElementById('password_confirmation')?.value;

                    this.formValid = name && email && password && confirm && password === confirm;
                }, 500);
            },
            createFloatingElements() {
                const elements = [];
                const colors = ['from-cyan-400/10', 'from-purple-500/10', 'from-blue-500/10', 'from-emerald-500/10'];

                for (let i = 0; i < 12; i++) {
                    elements.push({
                        id: i,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        size: Math.random() * 30 + 15,
                        top: Math.random() * 100,
                        left: Math.random() * 100,
                        speed: Math.random() * 2 + 0.5
                    });
                }
                this.floatingElements = elements;
            },
            checkPasswordStrength(password) {
                let strength = 0;
                if (password.length >= 8) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[^A-Za-z0-9]/.test(password)) strength += 25;

                this.passwordStrength = strength;
                return strength;
            },
            getStrengthColor(strength) {
                if (strength < 25) return 'from-red-500 to-red-600';
                if (strength < 50) return 'from-orange-500 to-orange-600';
                if (strength < 75) return 'from-yellow-500 to-yellow-600';
                return 'from-green-500 to-emerald-600';
            },
            getStrengthText(strength) {
                if (strength < 25) return 'Очень слабый';
                if (strength < 50) return 'Слабый';
                if (strength < 75) return 'Средний';
                return 'Надежный';
            },
            togglePassword(field) {
                if (field === 'password') {
                    this.showPassword = !this.showPassword;
                    const input = document.getElementById('password');
                    input.type = this.showPassword ? 'text' : 'password';
                } else {
                    this.showConfirmPassword = !this.showConfirmPassword;
                    const input = document.getElementById('password_confirmation');
                    input.type = this.showConfirmPassword ? 'text' : 'password';
                }
            },
            animateProgress() {
                this.progressValue = 100;
                setTimeout(() => {
                    this.progressValue = 0;
                }, 1000);
            }
        }"
        class="min-h-screen bg-gradient-to-br from-slate-950 via-gray-900 to-slate-950 overflow-hidden"
        style="background-image: radial-gradient(circle at 20% 50%, rgba(56, 189, 248, 0.08) 0%, transparent 50%), radial-gradient(circle at 80% 30%, rgba(168, 85, 247, 0.08) 0%, transparent 50%);"
    >

        <!-- Плавающие элементы фона -->
        <template x-for="element in floatingElements" :key="element.id">
            <div
                :class="[
                    'absolute rounded-full bg-gradient-to-r ' + element.color + ' to-transparent',
                    'backdrop-blur-sm'
                ]"
                :style="`
                    top: ${element.top}%;
                    left: ${element.left}%;
                    width: ${element.size}px;
                    height: ${element.size}px;
                    animation: float ${3 + element.speed}s ease-in-out infinite;
                    animation-delay: ${element.id * 0.3}s;
                    opacity: ${0.1 + Math.random() * 0.2};
                `"
            ></div>
        </template>

        <!-- Анимированные элементы безопасности -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <i data-lucide="shield" class="absolute top-1/4 left-10 w-20 h-20 text-cyan-500/10 animate-float-slow"></i>
            <i data-lucide="lock" class="absolute top-1/3 right-20 w-16 h-16 text-purple-500/10 animate-float"></i>
            <i data-lucide="key" class="absolute bottom-1/4 left-20 w-18 h-18 text-blue-500/10 animate-float-slower"></i>
            <i data-lucide="fingerprint" class="absolute bottom-1/3 right-10 w-14 h-14 text-emerald-500/10 animate-float"></i>
            <i data-lucide="user-check" class="absolute top-10 left-1/2 w-12 h-12 text-cyan-400/10 animate-pulse"></i>
        </div>

        <!-- HEADER -->
        <header
            :class="scrolled || isMenuOpen ? 'bg-slate-900/80 backdrop-blur-xl shadow-2xl shadow-cyan-500/10' : 'bg-slate-900/20 backdrop-blur-md'"
            class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-white/5"
        >
            <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
                <!-- Логотип -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur opacity-70 group-hover:opacity-100 transition-opacity"></div>
                        <i data-lucide="shield" class="w-8 h-8 text-cyan-400 relative z-10 group-hover:scale-110 transition-transform"></i>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent bg-size-200 animate-gradient">
                        CyberSafe Trainer
                    </span>
                </a>

                <!-- Навигация для десктопа -->
                <div class="hidden md:flex gap-6 items-center">
                    <a href="{{ url('/') }}"
                       class="relative px-4 py-2 text-white/80 hover:text-cyan-400 transition-all group">
                        <span class="relative z-10 flex items-center gap-2">
                            <i data-lucide="home" class="w-4 h-4"></i>
                            На главную
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/0 via-cyan-500/10 to-cyan-500/0 rounded-full scale-0 group-hover:scale-100 transition-transform duration-300"></div>
                    </a>

                    <a href="{{ route('login') }}"
                       class="px-6 py-2 rounded-full border border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10 transition-all">
                        Войти
                    </a>
                </div>

                <!-- Мобильная кнопка меню -->
                <button class="md:hidden relative w-10 h-10" @click="isMenuOpen = !isMenuOpen">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative w-full h-full flex items-center justify-center">
                        <i x-show="!isMenuOpen" data-lucide="menu" class="w-6 h-6 text-white"></i>
                        <i x-show="isMenuOpen" data-lucide="x" class="w-6 h-6 text-white"></i>
                    </div>
                </button>
            </nav>

            <!-- Мобильное меню -->
            <div x-show="isMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="md:hidden px-6 pb-6 space-y-3 bg-slate-900/90 backdrop-blur-xl border-t border-white/10">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 transition-all">
                    <i data-lucide="home" class="w-5 h-5"></i>
                    На главную
                </a>
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white/5 hover:bg-white/10 transition-all">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    Войти
                </a>
            </div>
        </header>

        <!-- REGISTER FORM SECTION -->
        <section class="min-h-screen flex items-center justify-center px-6 py-20">
            <div class="container mx-auto max-w-5xl">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Левый блок с информацией -->
                    <div class="relative">
                        <!-- Анимированный фон для левого блока -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-3xl blur opacity-20 animate-pulse"></div>

                        <div class="relative p-8 lg:p-12 bg-slate-900/50 backdrop-blur-xl rounded-2xl border border-white/10">
                            <div class="mb-8">
                                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30 mb-6">
                                    <div class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></div>
                                    <span class="text-cyan-300 font-semibold">Защищенная регистрация</span>
                                </div>

                                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                                    Создайте
                                    <span class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                                        безопасный аккаунт
                                    </span>
                                </h1>

                                <p class="text-gray-300 text-lg mb-8 leading-relaxed">
                                    Присоединяйтесь к сообществу CyberSafe Trainer и получите доступ к интерактивным курсам по кибербезопасности, персональной статистике и эксклюзивным материалам.
                                </p>
                            </div>

                            <!-- Преимущества регистрации -->
                            <div class="space-y-6">
                                <div class="flex items-start gap-4 group">
                                    <div class="flex-shrink-0 p-3 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 border border-cyan-500/30 group-hover:scale-110 transition-transform">
                                        <i data-lucide="shield-check" class="w-6 h-6 text-cyan-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white mb-2">Защита данных</h3>
                                        <p class="text-gray-400">Все ваши данные шифруются по стандартам военного уровня</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4 group">
                                    <div class="flex-shrink-0 p-3 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 group-hover:scale-110 transition-transform">
                                        <i data-lucide="zap" class="w-6 h-6 text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white mb-2">Интерактивное обучение</h3>
                                        <p class="text-gray-400">Практикуйтесь на реалистичных симуляциях кибератак</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4 group">
                                    <div class="flex-shrink-0 p-3 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30 group-hover:scale-110 transition-transform">
                                        <i data-lucide="trending-up" class="w-6 h-6 text-purple-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white mb-2">Персональный прогресс</h3>
                                        <p class="text-gray-400">Отслеживайте свои успехи и получайте рекомендации</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Статистика -->
                            <div class="mt-10 p-6 rounded-xl bg-gradient-to-r from-slate-800/50 to-slate-900/50 border border-white/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-3xl font-bold text-cyan-400">{{ $totalUsers ?? '10,000+' }}</div>
                                        <div class="text-gray-400">Уже с нами</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-emerald-400">24/7</div>
                                        <div class="text-gray-400">Поддержка</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Правый блок с формой -->
                    <div>
                        <!-- Основная карточка формы -->
                        <div class="relative group">
                            <!-- Эффект свечения вокруг формы -->
                            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-purple-500 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-1000"></div>

                            <div class="relative p-8 lg:p-10 bg-slate-900/80 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl">
                                <!-- Заголовок формы -->
                                <div class="mb-8 text-center">
                                    <div class="inline-flex items-center gap-3 mb-4">
                                        <div class="p-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500">
                                            <i data-lucide="user-plus" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <h2 class="text-3xl font-bold text-white">Создать аккаунт</h2>
                                    </div>
                                    <p class="text-gray-400">Заполните форму ниже для регистрации</p>
                                </div>

                                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                                    @csrf

                                    <!-- Имя -->
                                    <div class="relative group">
                                        <label for="name" class="block mb-3 text-gray-300 font-semibold">
                                            <span class="flex items-center gap-2">
                                                <i data-lucide="user" class="w-4 h-4 text-cyan-400"></i>
                                                Ваше имя
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input
                                                id="name"
                                                type="text"
                                                name="name"
                                                value="{{ old('name') }}"
                                                required
                                                autofocus
                                                autocomplete="name"
                                                x-on:input="animateProgress()"
                                                class="w-full px-5 py-4 rounded-xl bg-slate-800/70 text-white border border-white/10 focus:border-cyan-500/50 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all placeholder-gray-500"
                                                placeholder="Введите ваше имя"
                                            >
                                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-cyan-500/0 via-cyan-500/5 to-cyan-500/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                        </div>
                                        @error('name')
                                        <div class="mt-2 flex items-center gap-2 text-red-400">
                                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                            <p class="text-sm">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="relative group">
                                        <label for="email" class="block mb-3 text-gray-300 font-semibold">
                                            <span class="flex items-center gap-2">
                                                <i data-lucide="mail" class="w-4 h-4 text-blue-400"></i>
                                                Email адрес
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input
                                                id="email"
                                                type="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                required
                                                autocomplete="email"
                                                x-on:input="animateProgress()"
                                                class="w-full px-5 py-4 rounded-xl bg-slate-800/70 text-white border border-white/10 focus:border-blue-500/50 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all placeholder-gray-500"
                                                placeholder="your@email.com"
                                            >
                                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-blue-500/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                        </div>
                                        @error('email')
                                        <div class="mt-2 flex items-center gap-2 text-red-400">
                                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                            <p class="text-sm">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Пароль -->
                                    <div class="relative group">
                                        <label for="password" class="block mb-3 text-gray-300 font-semibold">
                                            <span class="flex items-center gap-2">
                                                <i data-lucide="lock" class="w-4 h-4 text-purple-400"></i>
                                                Пароль
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input
                                                id="password"
                                                :type="showPassword ? 'text' : 'password'"
                                                name="password"
                                                required
                                                autocomplete="new-password"
                                                x-on:input="checkPasswordStrength($event.target.value); animateProgress()"
                                                class="w-full px-5 py-4 rounded-xl bg-slate-800/70 text-white border border-white/10 focus:border-purple-500/50 focus:outline-none focus:ring-2 focus:ring-purple-500/20 transition-all placeholder-gray-500 pr-12"
                                                placeholder="Создайте надежный пароль"
                                            >
                                            <!-- Кнопка показать/скрыть пароль -->
                                            <button
                                                type="button"
                                                @click="togglePassword('password')"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 text-gray-400 hover:text-purple-400 transition-colors"
                                            >
                                                <i :data-lucide="showPassword ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                                            </button>
                                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-purple-500/0 via-purple-500/5 to-purple-500/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                        </div>

                                        <!-- Индикатор сложности пароля -->
                                        <div x-show="passwordStrength > 0" class="mt-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm text-gray-400">Сложность пароля:</span>
                                                <span class="text-sm font-semibold" :class="{
                                                    'text-red-400': passwordStrength < 25,
                                                    'text-orange-400': passwordStrength >= 25 && passwordStrength < 50,
                                                    'text-yellow-400': passwordStrength >= 50 && passwordStrength < 75,
                                                    'text-green-400': passwordStrength >= 75
                                                }" x-text="getStrengthText(passwordStrength)"></span>
                                            </div>
                                            <div class="h-2 bg-slate-800 rounded-full overflow-hidden">
                                                <div
                                                    class="h-full bg-gradient-to-r transition-all duration-500"
                                                    :class="getStrengthColor(passwordStrength)"
                                                    :style="`width: ${passwordStrength}%`"
                                                ></div>
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500">
                                                Используйте заглавные буквы, цифры и специальные символы
                                            </div>
                                        </div>

                                        @error('password')
                                        <div class="mt-2 flex items-center gap-2 text-red-400">
                                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                                            <p class="text-sm">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Подтверждение пароля -->
                                    <div class="relative group">
                                        <label for="password_confirmation" class="block mb-3 text-gray-300 font-semibold">
                                            <span class="flex items-center gap-2">
                                                <i data-lucide="lock" class="w-4 h-4 text-emerald-400"></i>
                                                Подтверждение пароля
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input
                                                id="password_confirmation"
                                                :type="showConfirmPassword ? 'text' : 'password'"
                                                name="password_confirmation"
                                                required
                                                autocomplete="new-password"
                                                x-on:input="animateProgress()"
                                                class="w-full px-5 py-4 rounded-xl bg-slate-800/70 text-white border border-white/10 focus:border-emerald-500/50 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all placeholder-gray-500 pr-12"
                                                placeholder="Повторите пароль"
                                            >
                                            <!-- Кнопка показать/скрыть пароль -->
                                            <button
                                                type="button"
                                                @click="togglePassword('confirm')"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 p-2 text-gray-400 hover:text-emerald-400 transition-colors"
                                            >
                                                <i :data-lucide="showConfirmPassword ? 'eye-off' : 'eye'" class="w-5 h-5"></i>
                                            </button>
                                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-emerald-500/0 via-emerald-500/5 to-emerald-500/0 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                                        </div>
                                    </div>

                                    <!-- Чекбокс согласия -->
                                    <div class="flex items-start gap-3">
                                        <input
                                            type="checkbox"
                                            id="terms"
                                            name="terms"
                                            required
                                            class="mt-1 rounded border-white/20 bg-slate-800 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-slate-900"
                                        >
                                        <label for="terms" class="text-sm text-gray-400">
                                            Я соглашаюсь с
                                            <a href="#" class="text-cyan-400 hover:text-cyan-300 transition-colors">Условиями использования</a>
                                            и
                                            <a href="#" class="text-cyan-400 hover:text-cyan-300 transition-colors">Политикой конфиденциальности</a>
                                        </label>
                                    </div>

                                    <!-- Прогресс бар (анимация) -->
                                    <div class="relative h-2 rounded-full overflow-hidden bg-slate-800">
                                        <div
                                            class="absolute top-0 left-0 h-full bg-gradient-to-r from-cyan-500 to-blue-500 transition-all duration-300"
                                            :style="`width: ${progressValue}%`"
                                        ></div>
                                    </div>

                                    <!-- Кнопка отправки -->
                                    <button
                                        type="submit"
                                        :disabled="!formValid"
                                        :class="formValid ?
                                            'opacity-100 transform hover:-translate-y-1 cursor-pointer' :
                                            'opacity-50 cursor-not-allowed'"
                                        class="group relative w-full py-4 rounded-xl font-bold text-white transition-all duration-300"
                                    >
                                        <!-- Градиентный фон кнопки -->
                                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-xl group-hover:from-cyan-600 group-hover:to-blue-700 transition-all"></div>
                                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-xl blur opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>

                                        <!-- Содержимое кнопки -->
                                        <span class="relative z-10 flex items-center justify-center gap-3">
                                            <i data-lucide="shield-plus" class="w-5 h-5"></i>
                                            Создать защищенный аккаунт
                                            <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                                        </span>

                                        <!-- Анимация загрузки -->
                                        <div x-show="!formValid" class="absolute inset-0 flex items-center justify-center rounded-xl bg-slate-800/50">
                                            <div class="text-gray-400 text-sm">Заполните все поля правильно</div>
                                        </div>
                                    </button>
                                </form>

                                <!-- Разделитель -->
                                <div class="relative my-8">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-white/10"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-4 bg-slate-900/80 text-gray-500">Или войдите через</span>
                                    </div>
                                </div>

                                <!-- Социальные кнопки -->
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button"
                                            class="group relative p-3 rounded-xl bg-slate-800/50 border border-white/10 hover:border-blue-500/50 transition-all">
                                        <div class="flex items-center justify-center gap-3">
                                            <i data-lucide="brand-google" class="w-5 h-5 text-red-400"></i>
                                            <span class="text-gray-300 group-hover:text-white">Google</span>
                                        </div>
                                    </button>
                                    <button type="button"
                                            class="group relative p-3 rounded-xl bg-slate-800/50 border border-white/10 hover:border-blue-400/50 transition-all">
                                        <div class="flex items-center justify-center gap-3">
                                            <i data-lucide="brand-facebook" class="w-5 h-5 text-blue-400"></i>
                                            <span class="text-gray-300 group-hover:text-white">Facebook</span>
                                        </div>
                                    </button>
                                </div>

                                <!-- Ссылка на вход -->
                                <div class="mt-8 text-center">
                                    <p class="text-gray-400">
                                        Уже есть аккаунт?
                                        <a href="{{ route('login') }}"
                                           class="group inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition-colors font-semibold">
                                            <span>Войти в систему</span>
                                            <i data-lucide="log-in" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Дополнительная информация -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-500">
                                Нажимая "Создать аккаунт", вы соглашаетесь с нашей политикой безопасности.
                                <br>
                                Мы никогда не передаем ваши данные третьим лицам.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="relative py-8 px-6 border-t border-white/10 bg-slate-900/50">
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <!-- Логотип и копирайт -->
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield" class="w-6 h-6 text-cyan-400"></i>
                        <span class="text-lg font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                            CyberSafe Trainer
                        </span>
                    </div>

                    <!-- Ссылки -->
                    <div class="flex flex-wrap gap-6 justify-center">
                        <a href="{{ url('/') }}" class="text-gray-400 hover:text-cyan-400 transition-colors">Главная</a>
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-blue-400 transition-colors">Вход</a>
                        <a href="#" class="text-gray-400 hover:text-purple-400 transition-colors">Помощь</a>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">Контакты</a>
                    </div>

                    <!-- Информация о безопасности -->
                    <div class="text-sm text-gray-500 text-center md:text-right">
                        <div class="flex items-center gap-2 justify-center md:justify-end">
                            <i data-lucide="shield-check" class="w-4 h-4 text-green-400"></i>
                            <span>Защищено 256-bit SSL шифрованием</span>
                        </div>
                        <div class="mt-1">© 2025 CyberSafe Trainer. Все права защищены.</div>
                    </div>
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

            .bg-size-200 {
                background-size: 200% 200%;
            }

            /* Кастомные стили для инпутов */
            input:-webkit-autofill,
            input:-webkit-autofill:hover,
            input:-webkit-autofill:focus {
                -webkit-text-fill-color: white;
                -webkit-box-shadow: 0 0 0px 1000px rgba(30, 41, 59, 0.7) inset;
                transition: background-color 5000s ease-in-out 0s;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Анимация для прогресс-бара валидации */
            @keyframes progress-pulse {
                0% { opacity: 0.5; }
                50% { opacity: 1; }
                100% { opacity: 0.5; }
            }

            .progress-animation {
                animation: progress-pulse 1.5s ease-in-out infinite;
            }

            /* Анимация для появления ошибок */
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }

            .animate-shake {
                animation: shake 0.5s ease-in-out;
            }

            /* Стили для скроллбара */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: rgba(15, 23, 42, 0.5);
            }

            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #06b6d4, #3b82f6);
                border-radius: 4px;
            }
        </style>
    @endpush
@endsection
