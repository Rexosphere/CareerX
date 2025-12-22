<div class="navbar bg-base-100 sticky top-0 z-50 border-b border-base-300 shadow-sm">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative flex items-center justify-between">
        <!-- Left: Brand Logo -->
        <div class="flex-none flex items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-primary/10 text-primary flex items-center justify-center">
                    <x-icon name="o-academic-cap" class="w-5 h-5" />
                </div>
                <h2 class="text-lg font-bold tracking-tight">CareerX</h2>
            </a>
        </div>

        <!-- Center: Navigation Links (Desktop) -->
        <div class="hidden md:flex absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <ul class="menu menu-horizontal px-1 gap-2">
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
                <li class="px-2"><a href="{{ route('resources.index') }}" class="font-medium text-sm">Interview</a></li>
                <li class="px-2"><a href="{{ route('resources.index') }}" class="font-medium text-sm">About Us</a></li>
            </ul>
        </div>

        <!-- Right: Actions -->
        <div class="flex-none flex items-center gap-3">
            @guest
                <!-- Mobile Menu -->
                <div class="dropdown dropdown-end md:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <x-icon name="o-bars-3" class="w-6 h-6" />
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li>
                            <details x-data @click.outside="$el.removeAttribute('open')">
                                <summary>Jobs</summary>
                                <ul>
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
                        <li><a href="{{ route('students.index') }}">Companies</a></li>
                        <li>
                            <details x-data @click.outside="$el.removeAttribute('open')">
                                <summary>Career Advice</summary>
                                <ul>
                                    <li><a href="#">Cv creating sessions</a></li>
                                    <li><a href="#">Interview facing sessions</a></li>
                                    <li><a href="#">Industrial careers sessions</a></li>
                                    <li><a href="#">Academia careers sessions</a></li>
                                </ul>
                            </details>
                        </li>
                        <li><a href="{{ route('resources.index') }}">Interview</a></li>
                        <li><a href="{{ route('resources.index') }}">About Us</a></li>
                        <li class="menu-title mt-2">Account</li>
                        <li><a href="{{ route('login') }}">Log In</a></li>
                        <li><a href="{{ route('register') }}">Sign Up</a></li>
                    </ul>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-primary py-2 btn-sm hidden sm:inline-flex">
                        Applicant Login
                    </a>
                    <a href="{{ route('company-login') }}" class="btn btn-primary py-2 btn-sm">
                        Company Login
                    </a>
                </div>
            @else
                <!-- Mobile Menu -->
                <div class="dropdown dropdown-end md:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <x-icon name="o-bars-3" class="w-6 h-6" />
                    </div>
                    <ul tabindex="0"
                        class="menu dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li>
                            <details x-data @click.outside="$el.removeAttribute('open')">
                                <summary>Jobs</summary>
                                <ul>
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
                        <li><a href="{{ route('students.index') }}">Coursesli>
                        <li>
                            <details x-data @click.outside="$el.removeAttribute('open')">
                                <summary>Career Advice</summary>
                                <ul>
                                    <li><a href="#">Cv creating sessions</a></li>
                                    <li><a href="#">Interview facing sessions</a></li>
                                    <li><a href="#">Industrial careers sessions</a></li>
                                    <li><a href="#">Academia careers sessions</a></li>
                                </ul>
                            </details>
                        </li>
                        <li><a href="{{ route('resources.index') }}">Interview</a></li>
                        <li><a href="{{ route('resources.index') }}">About Us</a></li>
                        <li class="menu-title mt-2">Account</li>
                        <li><a href="{{ route('profile') }}">Profile</a></li>
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
                    <ul tabindex="0"
                        class="menu dropdown-content mt-3 z-10 p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-300">
                        <li class="menu-title">
                            <span>{{ auth()->user()->name }}</span>
                        </li>
                        <li><a href="{{ route('profile') }}">Profile</a></li>
                        <li><a href="#">Logout</a></li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</div>