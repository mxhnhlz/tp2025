@extends('layouts.app')

@section('content')
    <div x-data="dashboardData({{ json_encode($stats) }})"
         x-init="init()"
         class="min-h-screen overflow-hidden bg-gradient-to-br from-slate-950 via-gray-900 to-slate-950"
         style="background-image: radial-gradient(circle at 20% 80%, rgba(56, 189, 248, 0.15) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.15) 0%, transparent 50%);">

        <!-- Плавающие элементы фона -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
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
                    opacity: ${0.1 + Math.random() * 0.2};
                `"
                ></div>
            </template>
        </div>

        <!-- HEADER -->
        <header
            x-data="{ isMenuOpen: false }"
            :class="isMenuOpen ? 'bg-slate-900/90 backdrop-blur-xl' : 'bg-slate-900/80 backdrop-blur-md'"
            class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-white/10 shadow-lg shadow-cyan-500/5"
        >
            <nav class="container mx-auto px-4 sm:px-6 py-3">
                <div class="flex items-center justify-between">
                    <!-- Лого -->
                    <a href="{{ url('/') }}" class="group flex items-center gap-3">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur group-hover:blur-md transition-all duration-300 opacity-70"></div>
                            <i data-lucide="shield"
                               class="w-8 h-8 sm:w-9 sm:h-9 text-cyan-400 relative z-10 group-hover:scale-110 transition-transform"></i>
                        </div>
                        <span
                            class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-400 via-blue-400 to-cyan-400 bg-clip-text text-transparent animate-gradient">
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
                           class="px-4 py-2.5 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all duration-200">
                            Разделы
                        </a>

                        @auth
                            <div class="relative group ml-2">
                                <!-- Аватар пользователя -->
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg cursor-pointer">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>

                                <!-- Выпадающее меню профиля -->
                                <div
                                    class="absolute right-0 mt-2 w-56 bg-slate-800/90 backdrop-blur-xl rounded-xl shadow-2xl border border-white/10 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                    <!-- Информация о пользователе -->
                                    <div class="p-4 border-b border-white/10">
                                        <p class="text-white font-semibold truncate">{{ auth()->user()->name }}</p>
                                        <p class="text-gray-400 text-sm truncate">{{ auth()->user()->email }}</p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <div
                                                class="px-2 py-1 bg-emerald-500/10 rounded text-xs text-emerald-400 border border-emerald-500/20">
                                                Уровень {{ auth()->user()->level }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ссылки профиля -->
                                    <div class="p-2">
                                        <a href="{{ route('dashboard') }}"
                                           class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all duration-200">
                                            <i data-lucide="user" class="w-4 h-4"></i>
                                            <span>Личный кабинет</span>
                                        </a>
                                        <a href="{{ route('achievements.index') }}"
                                           class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-gray-300 hover:text-yellow-400 hover:bg-white/5 transition-all duration-200">
                                            <i data-lucide="trophy" class="w-4 h-4"></i>
                                            <span>Достижения</span>
                                        </a>

                                    </div>

                                    <!-- Выход -->
                                    <div class="p-2 border-t border-white/10">
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
                                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                                <span>Выйти из аккаунта</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('register') }}"
                               class="ml-4 px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-medium rounded-lg
                              hover:shadow-lg hover:shadow-cyan-500/25 transition-all duration-300">
                                Вход / Регистрация
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile button -->
                    <button @click="isMenuOpen = !isMenuOpen"
                            class="md:hidden p-2.5 rounded-lg hover:bg-white/5 transition-colors relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur opacity-0 group-hover:opacity-20 transition-opacity"></div>
                        <div class="relative">
                            <i x-show="!isMenuOpen" data-lucide="menu" class="w-6 h-6 text-white"></i>
                            <i x-show="isMenuOpen" data-lucide="x" class="w-6 h-6 text-white"></i>
                        </div>
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
                           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
                            <i data-lucide="folder-open" class="w-5 h-5"></i>
                            Разделы
                        </a>

                        @auth
                            <!-- Информация о пользователе в мобильном меню -->
                            <div class="px-4 py-3 border-t border-white/10 mt-3">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                                        <p class="text-gray-400 text-xs">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <a href="{{ route('dashboard') }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-cyan-400 hover:bg-white/5 transition-all">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                        Личный кабинет
                                    </a>
                                    <a href="{{ route('achievements.index') }}"
                                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:text-yellow-400 hover:bg-white/5 transition-all">
                                        <i data-lucide="trophy" class="w-4 h-4"></i>
                                        Достижения
                                    </a>
                                </div>

                                <div class="mt-3 pt-3 border-t border-white/10">
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                                        @csrf
                                        <button type="submit"
                                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:shadow-lg hover:shadow-red-500/25 transition-all">
                                            <i data-lucide="log-out" class="w-4 h-4"></i>
                                            Выйти из аккаунта
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="pt-2">
                                <a href="{{ route('register') }}"
                                   class="flex items-center justify-center gap-3 px-4 py-3 bg-gradient-to-r from-cyan-500 to-blue-600
                                  text-white font-medium rounded-lg hover:shadow-lg hover:shadow-cyan-500/25 transition-all">
                                    <i data-lucide="log-in" class="w-5 h-5"></i>
                                    Войти / Регистрация
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        <!-- MAIN CONTENT -->
        <div class="pt-24 px-6 pb-20">
            <div class="container mx-auto max-w-7xl">

                <!-- Приветствие и уровень -->
                <div class="mb-8">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">
                        Привет, <span
                            class="bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">{{ $user->name }}</span>!
                        👋
                    </h1>
                    <p class="text-gray-400 text-lg">Ваш прогресс в освоении кибербезопасности</p>
                </div>

                <!-- Основная статистика -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                    <!-- Карточка уровня -->
                    <div class="lg:col-span-2">
                        <div class="relative group">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-purple-500 rounded-3xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
                            <div
                                class="relative p-8 bg-slate-900/70 backdrop-blur-xl rounded-2xl border border-white/10">
                                <div class="flex items-center justify-between mb-8">
                                    <div>
                                        <h2 class="text-2xl font-bold text-white mb-2">Уровень <span class="text-5xl"
                                                                                                     x-text="stats.level"></span>
                                        </h2>
                                        <p class="text-gray-400">Кибер-защитник</p>
                                    </div>
                                    <div class="relative">
                                        <div class="w-32 h-32">
                                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                                <!-- Фон круга -->
                                                <circle cx="50" cy="50" r="45" fill="none" stroke="#1e293b"
                                                        stroke-width="8"/>
                                                <!-- Прогресс -->
                                                <circle cx="50" cy="50" r="45" fill="none"
                                                        stroke="url(#gradient)" stroke-width="8"
                                                        stroke-linecap="round"
                                                        :stroke-dasharray="283"
                                                        :stroke-dashoffset="283 - (283 * (stats.xp / stats.next_level_xp))"
                                                        transform="rotate(-90 50 50)"/>
                                                <!-- Внутренний круг -->
                                                <circle cx="50" cy="50" r="35" fill="#0f172a"/>
                                                <defs>
                                                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                                        <stop offset="0%" stop-color="#06b6d4"/>
                                                        <stop offset="100%" stop-color="#3b82f6"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-white"
                                                     x-text="Math.round((stats.xp_to_next_level / stats.next_level_xp) * 100) + '%'"></div>
                                                <div class="text-sm text-gray-400">до уровня</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Прогресс бар -->
                                <div>
                                    <div class="flex justify-between text-gray-300 mb-2">
                                        <span>Опыт: <span x-text="stats.total_xp"
                                                          class="text-cyan-400 font-bold"></span> XP</span>
                                        <span x-text="stats.xp_to_next_level + ' XP до следующего уровня'"></span>
                                    </div>
                                    <div class="w-full h-4 bg-slate-800 rounded-full overflow-hidden">
                                        <div
                                            class="h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full transition-all duration-1000"
                                            :style="'width: ' + (stats.xp / stats.next_level_xp * 100) + '%'"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Быстрая статистика -->
                    <div class="space-y-6">


                        <!-- Точность -->
                        <div
                            class="p-6 bg-slate-900/70 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-purple-500/30 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="p-3 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-600/20 border border-purple-500/30">
                                    <i data-lucide="target" class="w-6 h-6 text-purple-400"></i>
                                </div>
                                <div>
                                    <div
                                        class="text-2xl font-bold text-white">{{ round($stats['average_accuracy'], 1) }}
                                        %
                                    </div>
                                    <div class="text-gray-400">Средняя точность</div>
                                </div>
                            </div>
                        </div>

                        <!-- Задания -->
                        <div
                            class="p-6 bg-slate-900/70 backdrop-blur-xl rounded-2xl border border-white/10 hover:border-cyan-500/30 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="p-3 rounded-xl bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 border border-cyan-500/30">
                                    <i data-lucide="check-circle" class="w-6 h-6 text-cyan-400"></i>
                                </div>
                                <div>
                                    <div
                                        class="text-2xl font-bold text-white">{{ $stats['total_tasks_completed'] }}</div>
                                    <div class="text-gray-400">Пройдено заданий</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Секции в 2 колонки -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Последние достижения -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                                <i data-lucide="trophy" class="w-6 h-6 text-yellow-400"></i>
                                Последние достижения
                            </h2>
                            <a href="{{ route('achievements.index') }}"
                               class="text-cyan-400 hover:text-cyan-300 text-sm flex items-center gap-1">
                                Все достижения <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentAchievements as $achievement)
                                <div class="group relative">
                                    <div
                                        class="absolute -inset-1 bg-gradient-to-r from-yellow-500/20 to-amber-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    <div
                                        class="relative p-4 bg-slate-900/70 backdrop-blur-sm rounded-xl border border-white/10 group-hover:border-yellow-500/30 transition-all duration-300">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="p-3 rounded-lg bg-gradient-to-br from-yellow-500/20 to-amber-600/20">
                                                <i data-lucide="{{ $achievement->icon ?? 'trophy' }}"
                                                   class="w-5 h-5 text-yellow-400"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-white">{{ $achievement->title }}</h4>
                                                <p class="text-sm text-gray-400">{{ $achievement->description }}</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-yellow-400 font-bold">+{{ $achievement->xp_reward }}
                                                    XP
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($achievement->pivot->unlocked_at)->format('d.m.Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center bg-slate-900/50 rounded-xl border border-white/10">
                                    <i data-lucide="trophy" class="w-12 h-12 text-gray-600 mx-auto mb-3"></i>
                                    <p class="text-gray-400">Пройдите задания, чтобы получить достижения</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Прогресс по разделам -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                                <i data-lucide="trending-up" class="w-6 h-6 text-emerald-400"></i>
                                Прогресс по разделам
                            </h2>
                        </div>

                        <div class="space-y-6">
                            @php
                                $visibleSections = $sections->take(3); // Показываем только первые 3 раздела
                                $hasMoreSections = $sections->count() > 3;
                            @endphp

                            @foreach($visibleSections as $section)
                                <a href="{{ route('sections.index', $section) }}"
                                   class="block group cursor-pointer hover:bg-white/5 transition-all duration-300 p-4 rounded-xl">
                                    <div class="flex justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 rounded-lg bg-gradient-to-br
                                                from-{{ $section->color ?? 'cyan' }}-500/20
                                                to-{{ $section->color ?? 'cyan' }}-600/20">
                                                <i data-lucide="{{ $section->icon ?? 'lock' }}"
                                                   class="w-4 h-4 text-{{ $section->color ?? 'cyan' }}-400"></i>
                                            </div>
                                            <span class="text-white font-medium">
                                                {{ $section->title }}
                                            </span>
                                        </div>

                                        <span class="text-gray-400">
                                            {{ $section->completed_tasks }}/{{ $section->total_tasks }}
                                        </span>
                                    </div>

                                    <div class="h-2 bg-slate-800 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r
                                            from-{{ $section->color ?? 'cyan' }}-500
                                            to-{{ $section->color ?? 'cyan' }}-600
                                            rounded-full transition-all duration-1000"
                                             style="width: {{ $section->progress_percentage }}%">
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Скрытые разделы (показываются при нажатии на кнопку) -->
                            @if($hasMoreSections)
                                <div x-data="{ showAll: false }">
                                    <template x-if="showAll">
                                        <div>
                                            @foreach($sections->slice(3) as $section)
                                                <a href="{{ route('sections.show', $section) }}"
                                                   class="block group cursor-pointer hover:bg-white/5 transition-all duration-300 p-4 rounded-xl">
                                                    <div class="flex justify-between mb-2">
                                                        <div class="flex items-center gap-3">
                                                            <div class="p-2 rounded-lg bg-gradient-to-br
                                                                from-{{ $section->color ?? 'cyan' }}-500/20
                                                                to-{{ $section->color ?? 'cyan' }}-600/20">
                                                                <i data-lucide="{{ $section->icon ?? 'lock' }}"
                                                                   class="w-4 h-4 text-{{ $section->color ?? 'cyan' }}-400"></i>
                                                            </div>
                                                            <span class="text-white font-medium">
                                                                {{ $section->title }}
                                                            </span>
                                                        </div>

                                                        <span class="text-gray-400">
                                                            {{ $section->completed_tasks }}/{{ $section->total_tasks }}
                                                        </span>
                                                    </div>

                                                    <div class="h-2 bg-slate-800 rounded-full overflow-hidden">
                                                        <div class="h-full bg-gradient-to-r
                                                            from-{{ $section->color ?? 'cyan' }}-500
                                                            to-{{ $section->color ?? 'cyan' }}-600
                                                            rounded-full transition-all duration-1000"
                                                             style="width: {{ $section->progress_percentage }}%">
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </template>

                                    <button @click="showAll = !showAll"
                                            class="w-full mt-4 px-4 py-3 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 text-cyan-400
                                                   hover:from-cyan-500/20 hover:to-blue-500/20 rounded-xl transition-all duration-300
                                                   flex items-center justify-center gap-2">
                                        <template x-if="!showAll">
                                            <span>
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                                Показать еще {{ $sections->count() - 3 }} разделов
                                            </span>
                                        </template>
                                        <template x-if="showAll">
                                            <span>
                                                <i data-lucide="chevron-up" class="w-4 h-4"></i>
                                                Скрыть разделы
                                            </span>
                                        </template>
                                    </button>
                                </div>
                            @endif

                            @if($sections->isEmpty())
                                <div class="p-6 text-center bg-slate-900/50 rounded-xl border border-white/10">
                                    <i data-lucide="folder-open" class="w-12 h-12 text-gray-600 mx-auto mb-3"></i>
                                    <p class="text-gray-400">Нет доступных разделов</p>
                                    <a href="{{ route('sections.index') }}"
                                       class="inline-block mt-3 px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-600
                                              rounded-full text-white hover:shadow-lg hover:shadow-cyan-500/25 transition-all">
                                        Перейти к разделам
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Недавняя активность -->
                <div class="mt-12">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                            <i data-lucide="activity" class="w-6 h-6 text-cyan-400"></i>
                            Недавняя активность
                        </h2>
                        <a href="{{ route('sections.index') }}"
                           class="text-cyan-400 hover:text-cyan-300 text-sm flex items-center gap-1">
                            Продолжить обучение <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($recentProgress as $progress)
                            <div class="group relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-xl blur opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                <div
                                    class="relative p-6 bg-slate-900/70 backdrop-blur-sm rounded-xl border border-white/10 group-hover:border-cyan-500/30 transition-all duration-300">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h4 class="font-bold text-white mb-1">{{ $progress->task->title }}</h4>
                                            <p class="text-sm text-gray-400">{{ $progress->task->section->title }}</p>
                                        </div>
                                        <span
                                            class="px-3 py-1 rounded-full text-sm font-medium bg-{{ $progress->task->difficulty === 'easy' ? 'green' : ($progress->task->difficulty === 'medium' ? 'yellow' : 'red') }}-500/20 text-{{ $progress->task->difficulty === 'easy' ? 'green' : ($progress->task->difficulty === 'medium' ? 'yellow' : 'red') }}-400">
                                    {{ $progress->task->difficulty === 'easy' ? 'Легко' : ($progress->task->difficulty === 'medium' ? 'Средне' : 'Сложно') }}
                                </span>
                                    </div>

                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <div class="text-2xl font-bold text-emerald-400">
                                                {{ $progress->accuracy }}%
                                            </div>
                                            <div class="text-sm text-gray-400">Точность</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-cyan-400">
                                                {{ round($progress->xp_earned) }}
                                            </div>
                                            <div class="text-sm text-gray-400">Получено XP</div>
                                        </div>
                                        <div>
                                            <div
                                                class="text-2xl font-bold text-white">{{ (new DateTimeImmutable($progress->completed_at))->format('d.m') }}</div>
                                            <div class="text-sm text-gray-400">Дата</div>
                                        </div>
                                    </div>

                                    <a href="{{ route('tasks.show', $progress->task) }}"
                                       class="block w-full py-2 text-center bg-gradient-to-r from-cyan-500/10 to-blue-500/10 text-cyan-400 rounded-lg hover:from-cyan-500/20 hover:to-blue-500/20 transition-all">
                                        Повторить задание
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div
                                class="md:col-span-3 p-8 text-center bg-slate-900/50 rounded-xl border border-white/10">
                                <i data-lucide="book-open" class="w-12 h-12 text-gray-600 mx-auto mb-3"></i>
                                <p class="text-gray-400 mb-4">Вы еще не прошли ни одного задания</p>
                                <a href="{{ route('sections.index') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full text-white font-semibold hover:shadow-lg hover:shadow-cyan-500/25 transition-all">
                                    Начать обучение
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Квик-действия -->
                <div
                    class="mt-12 p-8 bg-gradient-to-r from-slate-900/50 to-slate-800/50 backdrop-blur-xl rounded-2xl border border-white/10">
                    <h2 class="text-2xl font-bold text-white mb-6 text-center">Быстрые действия</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('sections.index') }}"
                           class="group p-6 text-center bg-slate-800/50 rounded-xl border border-white/10 hover:border-cyan-500/30 transition-all duration-300">
                            <div
                                class="w-12 h-12 mx-auto mb-4 rounded-full bg-gradient-to-r from-cyan-500/20 to-cyan-600/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-lucide="book-open" class="w-6 h-6 text-cyan-400"></i>
                            </div>
                            <span class="text-white font-medium">Продолжить обучение</span>
                        </a>

                        <a href="{{ route('achievements.index') }}"
                           class="group p-6 text-center bg-slate-800/50 rounded-xl border border-white/10 hover:border-yellow-500/30 transition-all duration-300">
                            <div
                                class="w-12 h-12 mx-auto mb-4 rounded-full bg-gradient-to-r from-yellow-500/20 to-amber-600/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i data-lucide="trophy" class="w-6 h-6 text-yellow-400"></i>
                            </div>
                            <span class="text-white font-medium">Мои достижения</span>
                        </a>

                        {{--                        <a href="{{ route('profile.edit') }}"--}}
                        {{--                           class="group p-6 text-center bg-slate-800/50 rounded-xl border border-white/10 hover:border-emerald-500/30 transition-all duration-300">--}}
                        {{--                            <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 flex items-center justify-center group-hover:scale-110 transition-transform">--}}
                        {{--                                <i data-lucide="user" class="w-6 h-6 text-emerald-400"></i>--}}
                        {{--                            </div>--}}
                        {{--                            <span class="text-white font-medium">Профиль</span>--}}
                        {{--                        </a>--}}


                    </div>
                </div>
            </div>
        </div>


        <!-- Тултипы для элементов -->
        <div x-show="tooltip.show"
             x-transition
             :style="'left: ' + tooltip.x + 'px; top: ' + tooltip.y + 'px'"
             class="fixed z-50 px-3 py-2 bg-slate-900 border border-white/10 rounded-lg shadow-xl"
             x-text="tooltip.text">
        </div>
    </div>

    <script>
        function dashboardData(stats) {
            return {
                // Состояние
                assistantOpen: false,
                notificationsOpen: false,
                tooltip: {
                    show: false,
                    x: 0,
                    y: 0,
                    text: ''
                },
                unreadNotifications: 3,
                floatingElements: [],
                mouseX: 0,
                mouseY: 0,
                stats: stats,

                init() {
                    // Инициализация плавающих элементов
                    this.createFloatingElements();

                    // Следим за движением мыши для параллакса
                    document.addEventListener('mousemove', (e) => {
                        this.mouseX = e.clientX / window.innerWidth;
                        this.mouseY = e.clientY / window.innerHeight;
                    });

                    // Инициализация иконок
                    this.$nextTick(() => {
                        if (window.lucide) {
                            lucide.createIcons();
                        }
                    });
                },

                createFloatingElements() {
                    const elements = [];
                    const shapes = ['circle', 'square'];
                    const colors = ['from-cyan-400/10', 'from-blue-500/10', 'from-purple-500/10'];

                    for (let i = 0; i < 20; i++) {
                        elements.push({
                            id: i,
                            shape: shapes[Math.floor(Math.random() * shapes.length)],
                            color: colors[Math.floor(Math.random() * colors.length)],
                            size: Math.random() * 30 + 10,
                            top: Math.random() * 100,
                            left: Math.random() * 100,
                            speed: Math.random() * 2 + 0.5,
                            direction: Math.random() > 0.5 ? 1 : -1
                        });
                    }
                    this.floatingElements = elements;
                },

                getTransform(index) {
                    const x = Math.sin(Date.now() / 2000 + index) * 5 * this.mouseX;
                    const y = Math.cos(Date.now() / 2000 + index) * 5 * this.mouseY;
                    return `translate(${x}px, ${y}px)`;
                },

                toggleAssistant() {
                    this.assistantOpen = !this.assistantOpen;
                },

                quickAction(action) {
                    switch (action) {
                        case 'next_task':
                            window.location.href = '{{ route("sections.index") }}';
                            break;
                        case 'achievements':
                            window.location.href = '{{ route("achievements.index") }}';
                            break;
                        case 'tips':
                            this.showTooltip('💡 Совет: Используйте разные пароли для разных сервисов!');
                            break;
                    }
                },

                showTooltip(text) {
                    this.tooltip = {
                        show: true,
                        x: event.clientX + 10,
                        y: event.clientY + 10,
                        text: text
                    };

                    setTimeout(() => {
                        this.tooltip.show = false;
                    }, 3000);
                }
            }
        }

        // Инициализация анимаций при загрузке
        document.addEventListener('DOMContentLoaded', function () {
            // Анимация счетчиков
            const counters = document.querySelectorAll('[x-data*="count"]');
            counters.forEach(counter => {
                // Уже обрабатывается Alpine
            });

            // Инициализация Lucide иконок
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    <style>
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(6, 182, 212, 0.6);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .clip-path-triangle {
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }

        /* Стилизация скроллбара */
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

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #0891b2, #2563eb);
        }

        /* Эффекты перехода */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Градиентный текст */
        .text-gradient {
            background: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endsection
