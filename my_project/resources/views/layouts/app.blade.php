<!DOCTYPE html>
<html lang="ru">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: '#22d3ee'
                }
            }
        }
    }
</script>

<head>
    <meta charset="UTF-8">
    <title>CyberSafe Trainer</title>

    <!-- ВАЖНО для адаптивки -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-slate-900 text-white">
@yield('content')

<script>
    lucide.createIcons();
</script>

</body>
</html>
