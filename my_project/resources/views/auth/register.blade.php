@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 px-4 py-12">
        <div class="max-w-md w-full bg-slate-800/50 backdrop-blur-md rounded-3xl p-10 border border-white/10 shadow-xl">
            <h2 class="text-4xl font-bold text-white text-center mb-6">Регистрация</h2>
            <p class="text-gray-300 text-center mb-8">Создайте аккаунт, чтобы начать обучение цифровой гигиене</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-gray-300 mb-2">Имя</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/50 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                    @error('name')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-gray-300 mb-2">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/50 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                    @error('email')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-gray-300 mb-2">Пароль</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/50 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                    @error('password')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-gray-300 mb-2">Подтвердите пароль</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/50 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="w-full py-3 px-6 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full font-bold text-lg hover:shadow-2xl transition-all transform hover:scale-105">
                        Зарегистрироваться
                    </button>
                </div>
            </form>

            <p class="text-gray-400 text-center mt-6">
                Уже есть аккаунт?
                <a href="{{ route('login') }}" class="text-cyan-400 hover:text-cyan-300 font-semibold">Войти</a>
            </p>
        </div>
    </div>
@endsection
