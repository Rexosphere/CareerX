@props(['title' => null, 'showNavbar' => true, 'showFooter' => true])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-partials.header :title="$title" />

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