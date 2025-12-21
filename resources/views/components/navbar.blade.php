<div class="navbar bg-base-100 sticky top-0 z-50 border-b border-base-300 shadow-sm">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <div class="flex-1">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-primary/10 text-primary flex items-center justify-center">
                    <x-icon name="o-academic-cap" class="w-5 h-5" />
                </div>
                <h2 class="text-lg font-bold tracking-tight">CareerX</h2>
            </a>
        </div>

        @guest
            <!-- Center: Navigation Links (Guest) -->
            <div class="flex-none hidden md:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('jobs.index') }}" class="font-medium">Jobs</a></li>
                    <li><a href="{{ route('students.index') }}" class="font-medium">Companies</a></li>
                    <li><a href="{{ route('resources.index') }}" class="font-medium">Resources</a></li>
                </ul>
            </div>

            <!-- Right: Actions -->
            <div class="flex-none gap-3 flex items-center">
                <!-- Mobile Menu -->
                <div class="dropdown dropdown-end md:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <x-icon name="o-bars-3" class="w-6 h-6" />
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li><a href="{{ route('jobs.index') }}">Jobs</a></li>
                        <li><a href="{{ route('students.index') }}">Companies</a></li>
                        <li><a href="{{ route('resources.index') }}">Resources</a></li>
                        <li class="menu-title mt-2">Account</li>
                        <li><a href="{{ route('login') }}">Log In</a></li>
                        <li><a href="{{ route('register') }}">Sign Up</a></li>
                    </ul>
                </div>

                <!-- Auth Buttons -->
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm hidden sm:inline-flex">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    Sign Up
                </a>
            </div>
        @else
            <!-- Center: Navigation Links (Logged In) -->
            <div class="flex-none hidden md:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="{{ route('jobs.index') }}" class="font-medium">Jobs</a></li>
                    <li><a href="{{ route('students.index') }}" class="font-medium">Companies</a></li>
                    <li><a href="{{ route('resources.index') }}" class="font-medium">Resources</a></li>
                </ul>
            </div>

            <!-- Right: Actions -->
            <div class="flex-none gap-2 flex items-center">
                <!-- Mobile Menu -->
                <div class="dropdown dropdown-end md:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <x-icon name="o-bars-3" class="w-6 h-6" />
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li><a href="{{ route('jobs.index') }}">Jobs</a></li>
                        <li><a href="{{ route('students.index') }}">Companies</a></li>
                        <li><a href="{{ route('resources.index') }}">Resources</a></li>
                        <li class="menu-title mt-2">Account</li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>

                <!-- User Dropdown -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full bg-base-300 flex items-center justify-center">
                            <span class="font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li class="menu-title">
                            <span>{{ auth()->user()->name }}</span>
                        </li>
                        <li><a href="#">Profile</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        @endguest
    </div>
</div>
