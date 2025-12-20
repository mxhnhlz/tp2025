<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админка')</title>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff, #dbeafe);
        }

        .glass {
            backdrop-filter: blur(10px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .sidebar a.active {
            background: #3b82f6;
            color: white;
            font-weight: 600;
        }

        .sidebar a:hover {
            transform: translateX(5px);
            transition: all 0.2s;
        }

        .alert {
            @apply fixed top-6 right-6 px-6 py-4 rounded-2xl shadow-lg text-white flex items-center gap-3 font-medium;
        }

        .alert-success {
            @apply bg-green-500;
        }

        .alert-error {
            @apply bg-red-500;
        }
    </style>
</head>
<body class="font-sans">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar w-72 flex flex-col p-6 glass rounded-r-3xl shadow-xl">
        <div class="flex items-center gap-3 mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Админка</h2>
        </div>

        <nav class="flex flex-col gap-3 text-gray-700 text-lg font-medium">
            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home mr-2"></i> Главная
            </a>
            <a href="{{ route('admin.sections.index') }}"
               class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group mr-2"></i> Разделы
            </a>
            <a href="{{ route('admin.tasks.index') }}"
               class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                <i class="fas fa-tasks mr-2"></i> Задания
            </a>
            <a href="{{ route('admin.theories.index') }}"
               class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.theories.*') ? 'active' : '' }}">
                <i class="fas fa-book mr-2"></i> Теория
            </a>
            <a href="{{ route('admin.questions.index') }}"
               class="px-4 py-3 rounded-xl {{ request()->routeIs('admin.questions.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle mr-2"></i> Вопросы
            </a>
        </nav>

        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit"
                    class="w-full mt-6 px-4 py-3 bg-red-600 text-white rounded-2xl shadow hover:bg-red-700 transition-all font-semibold">
                <i class="fas fa-sign-out-alt mr-2"></i> Выйти
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-auto">
        {{-- Alerts --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 x-init="setTimeout(() => show = false, 4000)"
                 class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-2"
                 x-init="setTimeout(() => show = false, 4000)"
                 class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Page Content --}}
        <div class="glass p-8 rounded-3xl shadow-2xl border border-white/30">
            @yield('content')
        </div>
    </main>

</div>

</body>
</html>
