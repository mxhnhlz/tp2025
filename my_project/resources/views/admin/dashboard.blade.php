@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Добро пожаловать 👋</h1>

    <div class="grid grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
            <p class="text-gray-600 text-sm">Всего разделов</p>
            <p class="text-3xl font-bold">{{ $sections }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
            <p class="text-gray-600 text-sm">Всего заданий</p>
            <p class="text-3xl font-bold">{{ $tasks }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
            <p class="text-gray-600 text-sm">Пользователей</p>
            <p class="text-3xl font-bold">{{ $users }}</p>
        </div>

    </div>
@endsection
