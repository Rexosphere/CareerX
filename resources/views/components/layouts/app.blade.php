<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    {{-- Favicons --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200 flex flex-col">

    {{-- Top Navigation Header --}}
    <x-navbar />

    {{-- Main Content --}}
    <main class="grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-base-100 border-t border-base-300 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 text-primary flex items-center justify-center">
                            <x-icon name="o-academic-cap" class="w-10 h-10" />
                        </div>
                        <span class="text-lg font-bold">CareerX</span>
                    </div>
                    <p class="text-sm text-base-content/70">
                        Connecting future leaders from University of Moratuwa with top industries.
                    </p>
                </div>

                <div class="flex flex-wrap gap-8 text-sm font-medium text-base-content/70">
                    <a class="link link-hover hover:text-primary" href="#">Privacy Policy</a>
                    <a class="link link-hover hover:text-primary" href="#">Terms of Service</a>
                    <a class="link link-hover hover:text-primary" href="#">Support</a>
                    <span class="text-base-content/40">© {{ date('Y') }} University of Moratuwa</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- TOAST area --}}
    <x-toast />
</body>

</html>