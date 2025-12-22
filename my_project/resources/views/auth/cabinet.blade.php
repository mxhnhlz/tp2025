@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900">
        <header class="py-6 px-6 text-white">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Личный кабинет</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-red-500 rounded-full hover:bg-red-600 transition">Выйти</button>
                </form>
            </div>
        </header>

        <main class="container mx-auto py-16 px-6 text-white">
            <h2 class="text-3xl font-bold mb-6">Привет, {{ auth()->user()->name }}!</h2>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div class="p-6 bg-slate-800/50 rounded-2xl border border-white/10">
                    <h3 class="text-2xl font-bold text-cyan-400 mb-2">Статистика</h3>
                    <p>Опыт: {{ auth()->user()->experience ?? 0 }}</p>
                    <p>Пройдено задач: {{ auth()->user()->userTaskProgress()->count() ?? 0 }} / {{ \App\Models\Task::count() }}</p>
                    <p>Достижения: {{ auth()->user()->achievements()->count() ?? 0 }}</p>
                </div>

                <div class="p-6 bg-slate-800/50 rounded-2xl border border-white/10">
                    <h3 class="text-2xl font-bold text-cyan-400 mb-2">Обучение</h3>
                    <a href="{{ route('sections.index') }}"
                       class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold hover:shadow-lg transition">
                        Начать обучение
                    </a>
                </div>
            </div>

            <!-- Достижения -->
            <div class="p-6 bg-slate-800/50 rounded-2xl border border-white/10">
                <h3 class="text-2xl font-bold text-cyan-400 mb-4">Ваши достижения</h3>

                <div class="grid md:grid-cols-3 gap-4">
                    @foreach(auth()->user()->achievements as $achievement)
                        <div class="bg-slate-700/50 p-4 rounded-lg border border-white/10 cursor-pointer"
                             @click="openModal('{{ $achievement->title }}', '{{ $achievement->description }}')">
                            <h4 class="text-lg font-bold text-white">{{ $achievement->title }}</h4>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        <!-- Модальное окно достижений -->
        <div x-data="{ showModal: false, title: '', description: '' }">
            <div x-show="showModal"
                 class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
                 x-transition>
                <div class="bg-slate-800 p-6 rounded-xl w-96 relative">
                    <button @click="showModal = false"
                            class="absolute top-2 right-2 text-gray-400 hover:text-white">&times;</button>
                    <h3 class="text-2xl font-bold text-cyan-400 mb-2" x-text="title"></h3>
                    <p class="text-gray-300" x-text="description"></p>
                </div>
            </div>

            <script>
                function openModal(title, description) {
                    const modal = document.querySelector('[x-data]');
                    modal.__x.$data.title = title;
                    modal.__x.$data.description = description;
                    modal.__x.$data.showModal = true;
                }
            </script>
        </div>

    </div>
@endsection
