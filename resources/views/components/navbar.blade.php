@php
    $admin = auth('admin')->user();
    $company = auth('company')->user();
    $user = auth('web')->user();

    // Prioritize Admin, then Company, then Student
    $anyUser = $admin ?: ($company ?: $user);
@endphp

<div class="navbar bg-base-100 sticky top-0 z-50 border-b border-base-300 shadow-sm">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative flex items-center justify-between">
        <!-- Left: Brand Logo -->
        <div class="flex-none flex items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-primary/10 text-primary flex items-center justify-center">
                    <x-icon name="o-academic-cap" class="w-5 h-5" />
                </div>
                <h2 class="text-lg font-bold tracking-tight text-base-content">CareerX</h2>
            </a>
        </div>

        <!-- Center: Navigation Links (Desktop) -->
        <div class="hidden md:flex absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <ul class="menu menu-horizontal px-1 gap-2">
                @if(!$admin)
                    {{-- Shared Links for Students/Companies/Guests --}}
                    <li class="px-2">
                        <details x-data @click.outside="$el.removeAttribute('open')">
                            <summary class="font-medium text-sm">Jobs</summary>
                            <ul class="p-2 bg-base-100 rounded-t-none w-64 shadow-lg z-50">
                                <li><a href="{{ route('jobs.index') }}" class="font-bold">All Jobs</a></li>
                                <li><a href="#">Software Engineering</a></li>
                                <li><a href="#">Data Science & AI</a></li>
                                <li><a href="#">Product Management</a></li>
                                <li><a href="#">Design (UI/UX)</a></li>
                                <li><a href="#">Marketing & Sales</a></li>
                                <li><a href="#">Finance & Accounting</a></li>
                                <li><a href="#">Human Resources</a></li>
                                <li><a href="#">Engineering</a></li>
                                <li><a href="#">Operations</a></li>
                                <li><a href="#">Internships</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="px-2"><a href="{{ route('students.index') }}" class="font-medium text-sm">Courses</a></li>
                    <li class="px-2">
                        <details x-data @click.outside="$el.removeAttribute('open')">
                            <summary class="font-medium text-sm">Career Advice</summary>
                            <ul class="p-2 bg-base-100 rounded-t-none w-64 shadow-lg z-50">
                                <li><a href="#">Cv creating sessions</a></li>
                                <li><a href="#">Interview facing sessions</a></li>
                                <li><a href="#">Industrial careers sessions</a></li>
                                <li><a href="#">Academia careers sessions</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="px-2"><a href="{{ route('resources.index') }}" class="font-medium text-sm text-nowrap">About
                            Us</a></li>

                    @if($company)
                        <li class="px-2 border-l border-base-300 ml-2 pl-4"><a href="{{ route('applicants.index') }}"
                                class="font-bold text-sm text-primary">Applicants</a></li>
                    @endif
                @else
                    {{-- Minimal Admin Nav --}}
                    <li class="px-2">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-2 font-bold text-primary group transition-all">
                            <x-icon name="o-shield-check" class="w-5 h-5 group-hover:scale-110" />
                            <span>Administrator Control Center</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <!-- Right: Actions -->
        <div class="flex-none flex items-center gap-3">
            {{-- Mobile Menu Trigger --}}
            <div class="dropdown dropdown-end md:hidden">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <x-icon name="o-bars-3" class="w-6 h-6" />
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                    @if(!$admin)
                        <li><a href="{{ route('jobs.index') }}">Jobs</a></li>
                        <li><a href="{{ route('students.index') }}">Courses</a></li>
                        <li><a href="{{ route('resources.index') }}">About Us</a></li>
                    @endif

                    @if($anyUser)
                        @if($company)
                            <li class="menu-title mt-2 text-primary">Company</li>
                            <li><a href="{{ route('applicants.index') }}">Applicants</a></li>
                            <li><a href="{{ route('jobs.create') }}">Post Job</a></li>
                            <li><a href="{{ route('company.profile') }}">Company Profile</a></li>
                        @elseif($admin)
                            <li class="menu-title mt-2 text-primary">Admin</li>
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="menu-title mt-2 text-primary">Student</li>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('profile') }}">My Profile</a></li>
                        @endif
                        <div class="divider my-1"></div>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                                @csrf
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                                    class="text-error">Logout</a>
                            </form>
                        </li>
                    @else
                        <li class="menu-title mt-2">Account</li>
                        <li><a href="{{ route('login') }}">Log In</a></li>
                        <li><a href="{{ route('company-login') }}">Company Login</a></li>
                    @endif
                </ul>
            </div>

            @if(!$anyUser)
                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary py-2 btn-sm hidden sm:inline-flex">
                        Applicant Login
                    </a>
                    <a href="{{ route('company-login') }}" class="btn btn-primary py-2 btn-sm">
                        Company Login
                    </a>
                </div>
            @else
                @if($company)
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-sm hidden md:inline-flex mr-2 gap-2">
                        <x-icon name="o-plus" class="w-4 h-4" />
                        <span>Post Job</span>
                    </a>
                @endif

                <!-- User Dropdown (Desktop) -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button"
                        class="btn btn-ghost btn-circle avatar border border-base-300 focus:outline-none">
                        <div class="w-10 rounded-full bg-base-300 flex items-center justify-center">
                            @if($anyUser->name)
                                <span
                                    class="font-semibold text-base-content/70">{{ strtoupper(substr($anyUser->name, 0, 1)) }}</span>
                            @else
                                <x-icon name="o-user" class="w-5 h-5 text-base-content/70" />
                            @endif
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li class="menu-title">
                            <span class="text-base-content font-bold">{{ $anyUser->name }}</span>
                            <span class="text-xs opacity-50 block font-normal capitalize">
                                @if($admin) Administrator @elseif($company) Company @else Student @endif
                            </span>
                        </li>

                        @if($company)
                            <li><a href="{{ route('company.profile') }}"><x-icon name="o-building-office" class="w-4 h-4" />
                                    Company Profile</a></li>
                            <li><a href="{{ route('dashboard') }}"><x-icon name="o-home" class="w-4 h-4" /> Dashboard</a></li>
                        @elseif($admin)
                            <li><a href="{{ route('admin.dashboard') }}"><x-icon name="o-shield-check" class="w-4 h-4" /> Admin
                                    Panel</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}"><x-icon name="o-home" class="w-4 h-4" /> Dashboard</a></li>
                            <li><a href="{{ route('profile') }}"><x-icon name="o-user" class="w-4 h-4" /> My Profile</a></li>
                        @endif

                        <div class="divider my-1"></div>

                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop">
                                @csrf
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();"
                                    class="text-error flex items-center gap-2">
                                    <x-icon name="o-arrow-right-on-rectangle" class="w-4 h-4" />
                                    Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>