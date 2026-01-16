@props(['title' => 'CareerX'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-partials.header :title="$title" />

<body class="min-h-screen font-sans antialiased bg-base-200 flex flex-col">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <x-footer />

    {{-- TOAST area --}}
    <x-toast />
</body>

</html>