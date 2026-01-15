<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-partials.header :title="$title" />

<body class="min-h-screen font-sans antialiased bg-base-200 flex flex-col">

    {{-- Top Navigation Header --}}
    <x-navbar />

    {{-- Main Content --}}
    <main class="grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- TOAST area --}}
    <x-toast />
</body>

</html>