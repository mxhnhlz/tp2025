@extends('layouts.app')

@section('content')
    <div
        x-data="{
        isMenuOpen: false,
        scrolled: false,
        activeSection: 0,
        sectionsCount: 4
    }"
        x-init="
        window.addEventListener('scroll', () => scrolled = window.scrollY > 50);
        setInterval(() => activeSection = (activeSection + 1) % sectionsCount, 3000);
    "
        class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900"
    >

        <!-- HEADER -->
        <header
            :class="scrolled || isMenuOpen ? 'bg-slate-900/95 backdrop-blur-md shadow-lg' : 'bg-slate-900 md:bg-transparent'"
            class="fixed top-0 w-full z-50 transition-all duration-300"
        >
            <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="shield" class="w-8 h-8 text-cyan-400"></i>
                    <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                CyberSafe Trainer
            </span>
                </div>

                <!-- Desktop -->
                <div class="hidden md:flex gap-4 items-center">
                    <a href="#about" class="hover:text-cyan-400">О проекте</a>
                    <a href="{{ route('sections.index') }}" class="hover:text-cyan-400">Разделы</a>
                    <a href="#stats" class="hover:text-cyan-400">Статистика</a>

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
                </div>

                <!-- Mobile button -->
                <button class="md:hidden" @click="isMenuOpen = !isMenuOpen">
                    <i x-show="!isMenuOpen" data-lucide="menu"></i>
                    <i x-show="isMenuOpen" data-lucide="x"></i>
                </button>
            </nav>

            <!-- Mobile menu -->
            <div x-show="isMenuOpen" class="md:hidden px-6 pb-4 space-y-4 bg-slate-900/95 backdrop-blur-md">
                <a href="#about" class="block">О проекте</a>
                <a href="{{ route('sections.index') }}" class="block">Разделы</a>
                <a href="#stats" class="block">Статистика</a>

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
            </div>
        </header>


        <!-- HERO -->
        <section class="pt-32 pb-20 px-6 text-center">
            <div class="container mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold mb-6">
                    Научитесь
                    <span class="bg-gradient-to-r from-cyan-400 to-purple-600 bg-clip-text text-transparent">
                    безопасности
                </span>
                    в интернете
                </h1>

                <p class="text-xl text-gray-300 max-w-2xl mx-auto mb-10">
                    Интерактивная платформа для освоения навыков цифровой гигиены
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('sections.index') }}" class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold flex items-center gap-2">
                            Начать обучение
                            <i data-lucide="chevron-right"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold flex items-center gap-2">
                            Начать обучение
                            <i data-lucide="chevron-right"></i>
                        </a>
                    @endauth
                    <a href="#about" class="px-8 py-4 border border-white/20 rounded-full">
                        Узнать больше
                    </a>
                </div>
            </div>
        </section>

        <!-- ABOUT SECTION -->
        <section id="about" class="py-20 px-6 bg-black/20">
            <div class="container mx-auto max-w-4xl text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-white">
                    О проекте
                </h2>
                <p class="text-xl text-gray-300 mb-8">
                    <strong>CyberSafe Trainer</strong> — это интерактивная платформа для освоения навыков цифровой гигиены.
                </p>

                <div class="grid md:grid-cols-2 gap-8 text-left">
                    <!-- Преимущества -->
                    <div class="p-6 bg-slate-800/50 rounded-2xl border border-white/10">
                        <h3 class="text-2xl font-bold mb-3 text-cyan-400">Наши преимущества</h3>
                        <ul class="list-disc list-inside text-gray-300 space-y-2">
                            <li>Интерактивные задания по безопасности паролей, фишингу и конфиденциальности</li>
                            <li>Адаптивный дизайн для ПК и мобильных устройств</li>
                            <li>Персональный прогресс и статистика</li>
                            <li>Система достижений и обратная связь в реальном времени</li>
                        </ul>
                    </div>

                    <!-- Недостатки других -->
                    <div class="p-6 bg-slate-800/50 rounded-2xl border border-white/10">
                        <h3 class="text-2xl font-bold mb-3 text-red-400">Чего нет у других</h3>
                        <ul class="list-disc list-inside text-gray-300 space-y-2">
                            <li>Нет практических заданий — только теория</li>
                            <li>Отсутствует персональный прогресс</li>
                            <li>Не адаптированы под мобильные устройства</li>
                            <li>Нет интерактивной обратной связи</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <!-- SECTIONS -->
        <section id="sections" class="py-20 px-6 bg-black/30">
            <div class="container mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold text-center mb-10 text-white">Разделы обучения</h2>

                <div class="grid md:grid-cols-2 gap-8">
                    @php
                        $allSections = \App\Models\Section::all();
                        $sections = $allSections->take(4); // ограничиваем первыми 4
                    @endphp

                    @foreach($sections as $index => $section)
                        <a href="{{ route('sections.show', $section) }}"
                           :class="activeSection === {{ $index }} ? 'bg-white/10 border-white/30 shadow-2xl' : 'bg-white/5 border-white/10'"
                           class="p-8 rounded-2xl border transition-all hover:scale-105 flex flex-col"
                        >
                            <i data-lucide="{{ $section->icon ?? 'lock' }}" class="w-10 h-10 text-cyan-400 mb-4"></i>
                            <h3 class="text-2xl font-bold mb-2">{{ $section->title }}</h3>
                            <p class="text-gray-400 mb-4">{{ $section->description }}</p>
                            <span class="text-cyan-400 flex items-center gap-2">
                        Перейти <i data-lucide="chevron-right"></i>
                    </span>
                        </a>
                    @endforeach
                </div>

                @if($allSections->count() > 4)
                    <div class="text-center mt-10">
                        <a href="{{ route('sections.index') }}"
                           class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold inline-block hover:shadow-lg transition-all">
                            Посмотреть все разделы
                        </a>
                    </div>
                @endif
            </div>
        </section>


        <!-- FOOTER -->
        <footer class="py-8 border-t border-white/10 text-center">
            <p class="text-gray-400">
                © 2025 CyberSafe Trainer
            </p>
        </footer>
    </div>
@endsection
