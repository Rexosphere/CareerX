@props(['title' => null, 'showNavbar' => true, 'showFooter' => true])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen font-display antialiased bg-base-200 flex flex-col">

    @if($showNavbar)
        <x-navbar />
    @endif

    <main class="flex-grow">
        {{ $slot }}
    </main>

    @if($showFooter)
        <x-footer />
    @endif

    <x-toast />
    @stack('scripts')
</body>

</html>