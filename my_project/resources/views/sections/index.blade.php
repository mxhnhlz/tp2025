@extends('layouts.app') {{-- предполагаем, что у тебя есть основной layout --}}

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white" x-data="{ selectedSection: null, hoveredCard: null, isMenuOpen: false, userLevel: 12, userXP: 2450 }">

        {{-- Header --}}
        <header class="fixed top-0 w-full z-50 bg-slate-900/95 backdrop-blur-md shadow-lg">
            <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-cyan-400"><use xlink:href="#shield"/></svg>
                    <span class="text-2xl font-bold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                    Цифровая Гигиена
                </span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="hover:text-cyan-400 transition-colors">Главная</a>
                    <a href="/sections" class="text-cyan-400">Разделы</a>
                    <a href="/cabinet" class="hover:text-cyan-400 transition-colors">Личный кабинет</a>
                    <button class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-semibold hover:shadow-lg hover:shadow-cyan-500/50 transition-all">
                        Профиль
                    </button>
                </div>

                <button class="md:hidden" @click="isMenuOpen = !isMenuOpen">
                    <svg class="w-6 h-6" x-show="!isMenuOpen"><use xlink:href="#menu"/></svg>
                    <svg class="w-6 h-6" x-show="isMenuOpen"><use xlink:href="#x"/></svg>
                </button>
            </nav>
        </header>

        {{-- Main Content --}}
        <div class="pt-24 pb-12 px-6 container mx-auto max-w-7xl">

            {{-- User Progress Card --}}
            <div class="mb-12 p-8 rounded-3xl bg-gradient-to-r from-slate-800/80 to-slate-900/80 border border-white/10 backdrop-blur-sm">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="flex-1">
                        <h1 class="text-4xl font-bold mb-2">Разделы обучения</h1>
                        <p class="text-gray-400">Выберите раздел и начните изучение цифровой безопасности</p>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 mb-2">
                                <span class="text-2xl font-bold" x-text="userLevel"></span>
                            </div>
                            <p class="text-sm text-gray-400">Уровень</p>
                        </div>

                        <div class="text-center">
                            <div class="flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 mb-2">
                                <svg class="w-10 h-10"><use xlink:href="#trophy"/></svg>
                            </div>
                            <p class="text-sm text-gray-400" x-text="userXP + ' XP'"></p>
                        </div>
                    </div>
                </div>

                {{-- Progress Bar (пример) --}}
                @php
                    $sections = [
                        [
                            'id'=>1,'icon'=>'lock','title'=>'Безопасность паролей','description'=>'Создавайте непробиваемые пароли','color'=>'from-blue-500 to-cyan-500',
                            'bgGlow'=>'bg-blue-500/20','tasks'=>24,'completedTasks'=>18,'difficulty'=>'Начальный','xpReward'=>150,'estimatedTime'=>'2 часа',
                            'topics'=>['Сложность паролей','Менеджеры паролей','Двухфакторная аутентификация','Брутфорс атаки'],'locked'=>false
                        ],
                        [
                            'id'=>2,'icon'=>'alert-triangle','title'=>'Фишинг и мошенничество','description'=>'Научитесь распознавать угрозы','color'=>'from-red-500 to-orange-500',
                            'bgGlow'=>'bg-red-500/20','tasks'=>32,'completedTasks'=>12,'difficulty'=>'Средний','xpReward'=>200,'estimatedTime'=>'3 часа',
                            'topics'=>['Email фишинг','Социальная инженерия','Поддельные сайты','Телефонные мошенники'],'locked'=>false
                        ],
                        [
                            'id'=>3,'icon'=>'eye','title'=>'Конфиденциальность','description'=>'Контролируйте свои данные','color'=>'from-purple-500 to-pink-500',
                            'bgGlow'=>'bg-purple-500/20','tasks'=>28,'completedTasks'=>8,'difficulty'=>'Средний','xpReward'=>180,'estimatedTime'=>'2.5 часа',
                            'topics'=>['Настройки приватности','Отслеживание в интернете','Цифровой след','Анонимность онлайн'],'locked'=>false
                        ],
                        [
                            'id'=>4,'icon'=>'smartphone','title'=>'Безопасность устройств','description'=>'Защитите свои гаджеты','color'=>'from-green-500 to-emerald-500',
                            'bgGlow'=>'bg-green-500/20','tasks'=>20,'completedTasks'=>0,'difficulty'=>'Начальный','xpReward'=>120,'estimatedTime'=>'1.5 часа',
                            'topics'=>['Антивирусы','Обновления ПО','Шифрование данных','Публичный Wi-Fi'],'locked'=>true
                        ]
                    ];
                    $totalTasks = array_sum(array_column($sections,'tasks'));
                    $completedTotal = array_sum(array_column($sections,'completedTasks'));
                    $progressPercent = round($completedTotal/$totalTasks*100);
                @endphp

                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold">Общий прогресс</span>
                        <span class="text-sm font-semibold text-cyan-400">{{ $completedTotal }}/{{ $totalTasks }} заданий ({{ $progressPercent }}%)</span>
                    </div>
                    <div class="h-3 bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-600 transition-all duration-1000 ease-out rounded-full" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Sections Grid --}}
            <div class="grid md:grid-cols-2 gap-8">
                @foreach($sections as $section)
                    @php $progress = round($section['completedTasks'] / $section['tasks'] * 100); @endphp
                    <div class="group relative overflow-hidden rounded-3xl border transition-all duration-500 {{ $section['locked'] ? 'opacity-60 cursor-not-allowed border-white/10' : 'cursor-pointer hover:scale-105 border-white/20 hover:border-white/40' }}"
                         x-on:mouseenter="hoveredCard={{ $section['id'] }}" x-on:mouseleave="hoveredCard=null"
                         x-on:click="if(!{{ $section['locked'] }}) selectedSection={{ $section['id'] }}">

                        <div class="absolute inset-0 {{ $section['bgGlow'] }} blur-3xl transition-opacity duration-500" :class="hoveredCard=={{ $section['id'] }} ? 'opacity-50' : 'opacity-20'"></div>

                        <div class="relative bg-gradient-to-br from-slate-800/90 to-slate-900/90 backdrop-blur-sm p-8">
                            {{-- Icon --}}
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $section['color'] }} flex items-center justify-center mb-6 transform transition-transform duration-500" :class="hoveredCard=={{ $section['id'] }} ? 'scale-110 rotate-3' : ''">
                                <svg class="w-10 h-10 text-white"><use xlink:href="#{{ $section['icon'] }}"/></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3">{{ $section['title'] }}</h3>
                            <p class="text-gray-400 mb-6">{{ $section['description'] }}</p>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-cyan-400"><use xlink:href="#target"/></svg>
                                    <span class="text-sm text-gray-400">{{ $section['tasks'] }} заданий</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-400"><use xlink:href="#clock"/></svg>
                                    <span class="text-sm text-gray-400">{{ $section['estimatedTime'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-400"><use xlink:href="#trending-up"/></svg>
                                    <span class="text-sm text-gray-400">{{ $section['difficulty'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-400"><use xlink:href="#star"/></svg>
                                    <span class="text-sm text-gray-400">+{{ $section['xpReward'] }} XP</span>
                                </div>
                            </div>
                            @if(!$section['locked'])
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-semibold">Прогресс</span>
                                        <span class="text-sm font-semibold text-cyan-400">{{ $section['completedTasks'] }}/{{ $section['tasks'] }}</span>
                                    </div>
                                    <div class="h-2 bg-slate-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r {{ $section['color'] }}" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif
                            {{-- Topics --}}
                            <div class="mb-6">
                                <p class="text-xs font-semibold text-gray-500 mb-3">ЧТО ВЫ ИЗУЧИТЕ:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($section['topics'] as $topic)
                                        <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-xs text-gray-300">{{ $topic }}</span>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Action Button --}}
                            @if(!$section['locked'])
                                <button class="w-full py-3 rounded-xl font-semibold flex items-center justify-center gap-2 bg-gradient-to-r {{ $section['color'] }} hover:shadow-lg hover:shadow-cyan-500/50">
                                    Начать обучение
                                </button>
                            @else
                                <div class="w-full py-3 rounded-xl font-semibold flex items-center justify-center gap-2 bg-slate-700/50 text-gray-400 cursor-not-allowed">
                                    <svg class="w-5 h-5"><use xlink:href="#lock"/></svg>
                                    Завершите предыдущий раздел
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Modal --}}
            <div x-show="selectedSection" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-6" x-cloak>
                <div class="bg-slate-900 rounded-3xl max-w-2xl w-full p-8 border border-white/20">
                    <button class="absolute top-4 right-4 text-gray-400 hover:text-white" @click="selectedSection=null">&times;</button>
                    <template x-for="section in {{ json_encode($sections) }}" :key="section.id">
                        <div x-show="selectedSection == section.id">
                            <h2 class="text-3xl font-bold mb-4" x-text="section.title"></h2>
                            <p class="text-gray-400 mb-6" x-text="section.description"></p>
                            <div class="space-y-3 mb-6">
                                <h3 class="font-semibold text-lg">Темы раздела:</h3>
                                <template x-for="(topic, idx) in section.topics" :key="idx">
                                    <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center flex-shrink-0">
                                            <span class="text-sm font-bold" x-text="idx+1"></span>
                                        </div>
                                        <span class="text-gray-300" x-text="topic"></span>
                                    </div>
                                </template>
                            </div>
                            <button class="w-full py-4 rounded-xl font-bold text-lg flex items-center justify-center gap-2 bg-gradient-to-r" :class="section.color">
                                Начать прохождение
                            </button>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
@endsection
