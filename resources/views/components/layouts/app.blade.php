<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200 flex flex-col">

    {{-- Top Navigation Header --}}
    <header class="bg-base-100 border-b border-base-300 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Logo --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-8 h-8 text-primary flex items-center justify-center">
                            <x-icon name="o-academic-cap" class="w-8 h-8" />
                        </div>
                        <span class="text-xl font-bold tracking-tight">CareerX</span>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex flex-1 justify-end items-center gap-8">
                    <nav class="flex gap-6">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-base-content/70 hover:text-primary font-medium text-sm transition-colors">Dashboard</a>
                        @endauth
                        <a href="{{ route('jobs.index') }}" class="text-base-content/70 hover:text-primary font-medium text-sm transition-colors">Jobs</a>
                        <a href="{{ route('students.index') }}" class="text-base-content/70 hover:text-primary font-medium text-sm transition-colors">Students</a>
                        <a href="{{ route('blog.index') }}" class="text-base-content/70 hover:text-primary font-medium text-sm transition-colors">Blog</a>
                    </nav>

                    <div class="flex items-center gap-4">
                        @auth
                            {{-- User Avatar Dropdown --}}
                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                    <div class="w-9 rounded-full bg-base-300 flex items-center justify-center">
                                        <span class="font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                                    <li class="menu-title">
                                        <span>{{ auth()->user()->name }}</span>
                                    </li>
                                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('onboarding') }}">Profile</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                        @endauth
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button class="btn btn-ghost btn-circle">
                        <x-icon name="o-bars-3" class="w-6 h-6" />
                    </button>
                </div>
            </div>
        </div>
    </header>

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

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
