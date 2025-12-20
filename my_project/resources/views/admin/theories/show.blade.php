@extends('admin.layout')

@section('title', 'Просмотр теории')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Теория: {{ $theory->task->title }}</h1>
        <a href="{{ route('admin.theories.index') }}"
           class="px-5 py-2 bg-gray-200 text-gray-800 rounded-xl shadow hover:bg-gray-300 transition-all font-semibold">
            Назад
        </a>
    </div>

    <div class="bg-white glass p-6 rounded-2xl shadow-lg border border-white/20">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 prose max-w-full">
            {!! $theory->content !!}
        </div>
    </div>
@endsection
