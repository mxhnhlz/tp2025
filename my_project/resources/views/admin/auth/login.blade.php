<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

<div class="w-96 bg-white p-8 rounded-xl shadow">
    <h1 class="text-2xl font-semibold mb-6 text-center">Admin Panel</h1>

    @if(session('error'))
        <div class="text-red-500 text-sm mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="mb-4">
            <label class="text-sm block mb-1">Email</label>
            <input name="email" type="email" required
                   class="w-full border p-2 rounded focus:ring focus:border-black">
        </div>

        <div class="mb-4">
            <label class="text-sm block mb-1">Пароль</label>
            <input name="password" type="password" required
                   class="w-full border p-2 rounded focus:ring focus:border-black">
        </div>

        <button class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">
            Войти
        </button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

</body>
</html>
