<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduFlex') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Дополнительные стили для исправления z-index и прикрепления футера -->
    <style>
        /* Только для выпадающих меню повышаем z-index */
        .absolute[x-show],
        .fixed[x-show] {
            z-index: 200 !important;
        }

        /* Для главного баннера на домашней странице */
        .welcome-banner {
            position: relative;
            z-index: 1;
        }

        /* Для хедера, чтобы был выше баннера */
        header.sticky, nav.sticky {
            position: sticky;
            z-index: 100;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 flex flex-col min-h-screen">
    <div id="app" class="flex flex-col min-h-screen">
        @include('components.header')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
