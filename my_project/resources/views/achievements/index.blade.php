@extends('layouts.app')

@section('content')
    <div
        x-data="{
            hoveredAchievement: null,
            floatingElements: [],
            mouseX: 0,
            mouseY: 0,
            unlockedGlow: [],
            init() {
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
            },
            createFloatingElements() {
                const elements = [];
                const colors = ['from-cyan-400/10', 'from-purple-500/10', 'from-blue-500/10', 'from-emerald-500/10', 'from-yellow-500/10'];

                for (let i = 0; i < 20; i++) {
                    elements.push({
                        id: i,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        size: Math.random() * 30 + 15,
                        top: Math.random() * 100,
                        left: Math.random() * 100,
                        speed: Math.random() * 3 + 1,
                        direction: Math.random() > 0.5 ? 1 : -1
                    });
                }
                this.floatingElements = elements;
            },
            getTransform(index) {
                const x = Math.sin(Date.now() / (1000 + index * 100)) * 5 * this.mouseX;
                const y = Math.cos(Date.now() / (1000 + index * 100)) * 5 * this.mouseY;
                return `translate(${x}px, ${y}px)`;
            }
        }"
        class="min-h-screen bg-gradient-to-br from-slate-950 via-gray-900 to-slate-950 pt-24 px-6 relative overflow-hidden"
        style="background-image: radial-gradient(circle at 20% 80%, rgba(56, 189, 248, 0.05) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);"
    >
        <!-- Плавающие элементы фона -->
        <template x-for="element in floatingElements" :key="element.id">
            <div
                :class="[
                    'absolute rounded-full bg-gradient-to-r ' + element.color + ' to-transparent'
                ]"
                :style="`
                    top: ${element.top}%;
                    left: ${element.left}%;
                    width: ${element.size}px;
                    height: ${element.size}px;
                    animation: float ${3 + element.speed}s ease-in-out infinite;
                    animation-delay: ${element.id * 0.1}s;
                    transform: ${getTransform(element.id)};
                    opacity: ${0.1 + Math.random() * 0.2};
                `"
            ></div>
        </template>

        <!-- Параллакс фон -->
        <div class="parallax-bg fixed inset-0 -z-10 opacity-30">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
    </div>

    <div class="container mx-auto max-w-7xl relative z-10">
        <!-- Анимированный заголовок -->
        <div class="text-center mb-12">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 text-white">
                    <span class="block mb-2">
                        <span class="bg-gradient-to-r from-cyan-400 via-yellow-400 to-cyan-400 bg-clip-text text-transparent bg-size-200 animate-gradient">
                            🏆 Достижения
                        </span>
                    </span>
                <span class="block text-2xl md:text-3xl font-light text-white/70">
                        Ваша коллекция наград
                    </span>
            </h1>
        </div>

        <!-- Статистика с анимацией -->
        @php
            $totalAchievements = $achievements->count();
            $unlockedAchievements = $user->achievements()->count();
            $percentage = $totalAchievements > 0 ? round(($unlockedAchievements / $totalAchievements) * 100, 1) : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Всего достижений -->
            <div
                x-data="{ count: 0, target: {{ $totalAchievements }} }"
                x-init="() => {
                        const interval = setInterval(() => {
                            if (count < target) count++;
                            else clearInterval(interval);
                        }, 50)
                    }"
                class="group relative overflow-hidden"
            >
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative bg-slate-800/40 backdrop-blur-xl p-8 rounded-2xl border border-white/10 group-hover:border-cyan-500/50 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="relative mr-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-cyan-600 rounded-full blur opacity-70"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-full flex items-center justify-center">
                                <i data-lucide="trophy" class="w-8 h-8 text-white"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Всего достижений</p>
                            <p class="text-4xl font-bold text-white" x-text="count"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Получено -->
            <div
                x-data="{ count: 0, target: {{ $unlockedAchievements }} }"
                x-init="() => {
                        const interval = setInterval(() => {
                            if (count < target) count++;
                            else clearInterval(interval);
                        }, 50)
                    }"
                class="group relative overflow-hidden"
            >
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-green-600 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative bg-slate-800/40 backdrop-blur-xl p-8 rounded-2xl border border-white/10 group-hover:border-emerald-500/50 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="relative mr-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full blur opacity-70"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-full flex items-center justify-center">
                                <i data-lucide="check-circle" class="w-8 h-8 text-white"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Получено</p>
                            <p class="text-4xl font-bold text-white" x-text="count"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Прогресс -->
            <div class="group relative overflow-hidden">
                <div class="absolute -inset-1 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative bg-slate-800/40 backdrop-blur-xl p-8 rounded-2xl border border-white/10 group-hover:border-yellow-500/50 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="relative mr-6">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-full blur opacity-70"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-full flex items-center justify-center">
                                <i data-lucide="target" class="w-8 h-8 text-white"></i>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Прогресс</p>
                            <p
                                x-data="{ percentage: 0, target: {{ $percentage }} }"
                                x-init="() => {
                                        const interval = setInterval(() => {
                                            if (percentage < target) percentage++;
                                            else clearInterval(interval);
                                        }, 20)
                                    }"
                                class="text-4xl font-bold text-white"
                                x-text="`${percentage}%`"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Анимированный прогресс бар -->
        <div class="mb-12 group relative">
            <div class="flex justify-between text-gray-300 mb-4">
                <div class="flex items-center gap-3">
                    <span class="text-lg font-semibold">Заполнение коллекции</span>
                    <div class="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-500/30">
                            <span
                                x-data="{ count: 0, target: {{ $unlockedAchievements }} }"
                                x-init="() => {
                                    const interval = setInterval(() => {
                                        if (count < target) count++;
                                        else clearInterval(interval);
                                    }, 30)
                                }"
                                x-text="count"
                                class="text-cyan-400 font-bold"
                            ></span>
                        <span class="text-gray-400">/</span>
                        <span class="text-white">{{ $totalAchievements }}</span>
                    </div>
                </div>
                <span
                    x-data="{ percentage: 0, target: {{ $percentage }} }"
                    x-init="() => {
                            const interval = setInterval(() => {
                                if (percentage < target) percentage++;
                                else clearInterval(interval);
                            }, 20)
                        }"
                    class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent"
                    x-text="`${percentage}%`"
                ></span>
            </div>

            <div class="relative h-4 bg-slate-800/50 backdrop-blur-sm rounded-full overflow-hidden border border-white/10">
                <div
                    x-data="{ width: 0, target: {{ $percentage }} }"
                    x-init="() => {
                            const interval = setInterval(() => {
                                if (width < target) width += 0.5;
                                else { width = target; clearInterval(interval); }
                            }, 10)
                        }"
                    class="absolute inset-0 bg-gradient-to-r from-cyan-500 via-blue-500 to-purple-600 h-full rounded-full transition-all duration-1000"
                    :style="`width: ${width}%`"
                >
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shine"></div>
                </div>
            </div>
        </div>

        <!-- Сообщение если нет достижений -->
        @if($achievements->isEmpty())
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500"></div>
                <div class="relative bg-slate-800/40 backdrop-blur-xl p-12 rounded-2xl border border-white/10 text-center">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full blur opacity-70 animate-pulse"></div>
                        <i data-lucide="trophy" class="relative w-20 h-20 text-gray-500"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-300 mb-4">Достижений пока нет</h2>
                    <p class="text-gray-400 mb-8 max-w-md mx-auto">
                        Начните проходить задания, чтобы получить первые достижения и пополнить свою коллекцию!
                    </p>
                    <a href="{{ route('sections.index') }}"
                       class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/30 transition-all transform hover:-translate-y-1">
                        <span>Перейти к заданиям</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full blur opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </a>
                </div>
            </div>
        @else
            <!-- Сетка достижений -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($achievements as $achievement)
                    @php
                        $unlocked = $user->achievements->contains($achievement);
                        $unlockedAt = $unlocked ?
                            $user->achievements->find($achievement->id)->pivot->unlocked_at : null;
                        $colors = [
                            'cyan' => ['from-cyan-500', 'to-blue-500'],
                            'blue' => ['from-blue-500', 'to-cyan-500'],
                            'purple' => ['from-purple-500', 'to-pink-500'],
                            'emerald' => ['from-emerald-500', 'to-green-500'],
                            'yellow' => ['from-yellow-500', 'to-orange-500'],
                            'pink' => ['from-pink-500', 'to-rose-500'],
                            'orange' => ['from-orange-500', 'to-amber-500']
                        ];
                        $colorKey = array_keys($colors)[$loop->index % count($colors)];
                        $gradient = $colors[$colorKey];
                    @endphp

                    <div
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                        class="group relative"
                    >
                        <!-- Фон для разблокированных достижений -->
                        @if($unlocked)
                            <div class="absolute -inset-4 -z-10">
                                <div
                                    :class="hover ? 'opacity-100' : 'opacity-70'"
                                    class="absolute inset-0 bg-gradient-to-r {{ $gradient[0] }} {{ $gradient[1] }} rounded-3xl blur-xl transition-all duration-700"
                                ></div>
                                <div
                                    :class="hover ? 'opacity-40' : 'opacity-20'"
                                    class="absolute inset-0 bg-gradient-to-r {{ $gradient[0] }} {{ $gradient[1] }} rounded-3xl transition-all duration-700"
                                ></div>
                            </div>
                        @endif

                        <div
                            :class="[
                                    'relative rounded-2xl p-8 border transition-all duration-500 transform overflow-hidden',
                                    $unlocked
                                        ? 'bg-gradient-to-br from-slate-900/90 to-slate-950/90 backdrop-blur-xl border-{{ $colorKey }}-400/40 group-hover:border-{{ $colorKey }}-400/70 group-hover:scale-[1.02] shadow-2xl shadow-{{ $colorKey }}-500/20'
                                        : 'bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-lg border-slate-700/50 group-hover:border-slate-600/70 group-hover:scale-[1.01]'
                                ]"
                        >
                            <!-- Блестящий эффект для разблокированных -->
                            @if($unlocked)
                                <div class="absolute -inset-32 -rotate-45 -z-5 overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shine-slow"></div>
                                </div>
                            @endif

                            <!-- Верхняя часть с иконкой -->
                            <div class="flex flex-col items-center text-center mb-6">
                                <div class="relative mb-5">
                                    @if($unlocked)
                                        <!-- Анимированное кольцо вокруг иконки -->
                                        <div
                                            :class="hover ? 'scale-110' : ''"
                                            class="absolute -ins-4 border-2 border-{{ $colorKey }}-400/50 rounded-full animate-pulse-slow transition-transform duration-500"
                                        ></div>
                                        <div
                                            :class="hover ? 'scale-125 opacity-30' : 'opacity-20'"
                                            class="absolute -ins-6 bg-gradient-to-r {{ $gradient[0] }} {{ $gradient[1] }} rounded-full blur transition-all duration-500"
                                        ></div>
                                    @endif

                                    <div
                                        :class="[
                                                'relative w-20 h-20 rounded-2xl flex items-center justify-center transition-all duration-500 transform',
                                                $unlocked
                                                    ? 'bg-gradient-to-br {{ $gradient[0] }} {{ $gradient[1] }} shadow-lg shadow-{{ $colorKey }}-500/30 group-hover:shadow-xl group-hover:shadow-{{ $colorKey }}-500/50'
                                                    : 'bg-gradient-to-br from-slate-700 to-slate-900'
                                            ]"
                                    >
                                        @if($achievement->icon)
                                            <i data-lucide="{{ $achievement->icon }}"
                                               :class="[
                                                       'w-10 h-10 transition-all duration-500',
                                                       $unlocked ? 'text-white' : 'text-gray-500',
                                                       hover && $unlocked ? 'scale-110 rotate-12' : ''
                                                   ]"></i>
                                        @else
                                            <i data-lucide="trophy"
                                               :class="[
                                                       'w-10 h-10 transition-all duration-500',
                                                       $unlocked ? 'text-white' : 'text-gray-500',
                                                       hover && $unlocked ? 'scale-110 rotate-12' : ''
                                                   ]"></i>
                                        @endif
                                    </div>
                                </div>

                                <!-- Название и описание -->
                                <div class="mb-4">
                                    <h3
                                        :class="[
                                                'text-2xl font-bold mb-3 transition-all duration-500',
                                                $unlocked
                                                    ? 'text-white group-hover:text-{{ $colorKey }}-200'
                                                    : 'text-gray-400 group-hover:text-gray-300'
                                            ]"
                                    >
                                        {{ $achievement->title }}
                                    </h3>
                                    <p class="text-gray-300 leading-relaxed">{{ $achievement->description }}</p>
                                </div>

                                <!-- Награда XP -->
                                @if($achievement->xp_reward)
                                    <div
                                        :class="[
                                                'inline-flex items-center gap-3 px-5 py-2.5 rounded-full transition-all duration-500 mt-2',
                                                $unlocked
                                                    ? 'bg-gradient-to-r from-yellow-500/30 to-amber-500/30 border border-yellow-500/40 text-yellow-300 group-hover:from-yellow-500/40 group-hover:to-amber-500/40'
                                                    : 'bg-slate-700/50 border border-slate-600/50 text-gray-400'
                                            ]"
                                    >
                                        <i data-lucide="star"
                                           :class="[
                                                   'w-5 h-5',
                                                   $unlocked ? 'text-yellow-400 animate-bounce-slow' : 'text-gray-500'
                                               ]"></i>
                                        <span class="font-bold text-lg">+{{ $achievement->xp_reward }} XP</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Статус -->
                            <div class="pt-6 border-t border-white/10">
                                @if($unlocked && $unlockedAt)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-green-600 rounded-full blur opacity-60"></div>
                                                <div class="relative w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-700 rounded-full flex items-center justify-center">
                                                    <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-sm text-emerald-400 font-bold">ПОЛУЧЕНО</div>
                                                <div class="text-xs text-emerald-300/80">{{ \Carbon\Carbon::parse($unlockedAt)->translatedFormat('d F Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <div
                                                :class="hover ? 'opacity-100' : 'opacity-70'"
                                                class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-amber-600 rounded-full blur transition-opacity duration-500"
                                            ></div>
                                            <i data-lucide="sparkles"
                                               :class="[
                                                       'relative w-6 h-6 transition-all duration-500',
                                                       hover ? 'text-yellow-300 animate-spin' : 'text-yellow-400'
                                                   ]"></i>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <div
                                                    :class="[
                                                            'absolute inset-0 rounded-full blur transition-all duration-500',
                                                            hover ? 'bg-gradient-to-r from-slate-600 to-slate-700 opacity-40' : 'bg-gradient-to-r from-slate-700 to-slate-800 opacity-20'
                                                        ]"
                                                ></div>
                                                <div
                                                    :class="[
                                                            'relative w-10 h-10 rounded-full flex items-center justify-center transition-all duration-500',
                                                            hover ? 'bg-gradient-to-br from-slate-600 to-slate-800' : 'bg-gradient-to-br from-slate-700 to-slate-900'
                                                        ]"
                                                >
                                                    <i data-lucide="lock"
                                                       :class="[
                                                               'w-5 h-5 transition-all duration-500',
                                                               hover ? 'text-gray-300' : 'text-gray-500'
                                                           ]"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div
                                                    :class="[
                                                            'text-sm font-bold transition-all duration-500',
                                                            hover ? 'text-gray-300' : 'text-gray-500'
                                                        ]"
                                                >
                                                    НЕ ПОЛУЧЕНО
                                                </div>
                                                <div class="text-xs text-gray-500">Продолжайте обучение</div>
                                            </div>
                                        </div>
                                        <i data-lucide="clock"
                                           :class="[
                                                   'w-6 h-6 transition-all duration-500',
                                                   hover ? 'text-blue-400 animate-pulse' : 'text-gray-500'
                                               ]"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Дополнительные эффекты для разблокированных -->
                            @if($unlocked)
                                <!-- Частицы -->
                                <div class="absolute -z-1 inset-0 overflow-hidden pointer-events-none">
                                    <div class="absolute top-2 left-2 w-2 h-2 bg-{{ $colorKey }}-400 rounded-full animate-float-slow" style="animation-delay: 0s"></div>
                                    <div class="absolute top-4 right-4 w-1 h-1 bg-{{ $colorKey }}-300 rounded-full animate-float" style="animation-delay: 0.3s"></div>
                                    <div class="absolute bottom-6 left-6 w-1.5 h-1.5 bg-{{ $colorKey }}-500 rounded-full animate-float-slower" style="animation-delay: 0.6s"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Кнопки навигации -->
        <div class="mt-16 flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="{{ route('sections.index') }}"
               class="group relative px-10 py-4 rounded-2xl bg-gradient-to-r from-slate-800 to-slate-900 font-bold text-white hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 transform hover:-translate-y-1 border border-white/10 hover:border-blue-500/30 flex items-center gap-3">
                <i data-lucide="grid" class="w-5 h-5 text-blue-400 group-hover:rotate-12 transition-transform"></i>
                <span>К разделам</span>
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
            </a>

            <a href="{{ route('dashboard') }}"
               class="group relative px-10 py-4 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 font-bold text-white hover:shadow-2xl hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-3">
                <i data-lucide="user" class="w-5 h-5 text-white group-hover:scale-110 transition-transform"></i>
                <span>Личный кабинет</span>
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur opacity-30 group-hover:opacity-70 transition-opacity duration-300"></div>
            </a>
        </div>
    </div>
    </div>

    @push('styles')
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(5deg); }
            }

            @keyframes float-slow {
                0%, 100% { transform: translateY(0) scale(1); }
                50% { transform: translateY(-15px) scale(1.05); }
            }

            @keyframes float-slower {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-8px) rotate(10deg); }
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            @keyframes shine {
                0% { transform: translateX(-100%) rotate(45deg); }
                100% { transform: translateX(100%) rotate(45deg); }
            }

            @keyframes shine-slow {
                0% { transform: translateX(-100%) rotate(45deg); }
                100% { transform: translateX(400%) rotate(45deg); }
            }

            @keyframes pulse-slow {
                0%, 100% { opacity: 0.5; transform: scale(1); }
                50% { opacity: 1; transform: scale(1.05); }
            }

            @keyframes bounce-slow {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-5px); }
            }

            .animate-float {
                animation: float 4s ease-in-out infinite;
            }

            .animate-float-slow {
                animation: float-slow 5s ease-in-out infinite;
            }

            .animate-float-slower {
                animation: float-slower 6s ease-in-out infinite;
            }

            .animate-gradient {
                background-size: 200% 200%;
                animation: gradient 3s ease infinite;
            }

            .animate-shine {
                animation: shine 3s ease-in-out infinite;
            }

            .animate-shine-slow {
                animation: shine-slow 8s ease-in-out infinite;
            }

            .animate-pulse-slow {
                animation: pulse-slow 3s ease-in-out infinite;
            }

            .animate-bounce-slow {
                animation: bounce-slow 2s ease-in-out infinite;
            }

            .bg-size-200 {
                background-size: 200% 200%;
            }

            /* Параллакс эффекты */
            .parallax-bg {
                will-change: transform;
            }
        </style>
    @endpush
@endsection
