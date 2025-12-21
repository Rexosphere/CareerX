<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-display antialiased bg-base-200 flex items-center justify-center p-4">

    <main class="w-full flex items-center justify-center relative">
        <!-- Abstract Background Pattern -->
        <div class="absolute inset-0 z-0 opacity-40 pointer-events-none overflow-hidden">
            <div class="absolute -top-[20%] -right-[10%] w-[600px] h-[600px] bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[500px] h-[500px] bg-primary/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full">
            {{ $slot }}
        </div>
    </main>

    <x-toast />
</body>
</html>
