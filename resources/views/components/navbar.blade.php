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
                <img src="{{ asset('careerxlogo-black.avif') }}" alt="CareerX Logo" class="h-10 w-auto object-contain dark:hidden">
                <img src="{{ asset('careerxlogo.avif') }}" alt="CareerX Logo" class="h-10 w-auto object-contain hidden dark:block">
            </a>
        </div>

        <!-- Center: Navigation Links (Desktop) -->
        <div class="hidden md:flex absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <ul class="menu menu-horizontal px-1 gap-2">
                @if(!$admin)
                    {{-- Shared Links for Students/Companies/Guests --}}
                    <li class="px-2"><a href="{{ route('jobs.index') }}" class="font-medium text-sm">Jobs</a></li>
                    <li class="px-2"><a href="{{ route('courses.index') }}" class="font-medium text-sm">Courses</a></li>
                    <li class="px-2"><a href="{{ route('blog.index') }}" class="font-medium text-sm">Career Advice</a></li>

                    @if($company)
                        <li class="px-2 border-l border-base-300 ml-2 pl-4"><a href="{{ route('students.index') }}"
                                class="font-bold text-sm text-primary">Job Seekers</a></li>
                    @endif
                @else
                    {{-- Admin Nav --}}
                    <li class="px-1">
                        <a href="{{ route('admin.dashboard', ['tab' => 'overview']) }}"
                            class="font-bold text-sm {{ request('tab') == 'overview' ? 'text-primary' : 'text-base-content/70' }} flex items-center gap-2">
                            <x-icon name="o-squares-2x2" class="w-4 h-4" />
                            Overview
                        </a>
                    </li>
                    <li class="px-1">
                        <details x-data @click.outside="$el.removeAttribute('open')"
                            class="{{ request('tab') == 'courses' ? 'text-primary' : '' }}">
                            <summary class="font-bold text-sm flex items-center gap-2">
                                <x-icon name="o-academic-cap" class="w-4 h-4" />
                                Courses
                            </summary>
                            <ul class="p-2 bg-base-100 rounded-t-none w-56 shadow-lg z-50">
                                <li>
                                    <a href="{{ route('admin.dashboard', ['tab' => 'courses', 'subTab' => 'list']) }}"
                                        class="{{ request('tab') == 'courses' && request('subTab') == 'list' ? 'font-bold text-primary bg-primary/5' : '' }}">
                                        <x-icon name="o-list-bullet" class="w-4 h-4" />
                                        View All Courses
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.dashboard', ['tab' => 'courses', 'subTab' => 'form']) }}"
                                        class="{{ request('tab') == 'courses' && request('subTab') == 'form' ? 'font-bold text-primary bg-primary/5' : '' }}">
                                        <x-icon name="o-plus-circle" class="w-4 h-4" />
                                        Add New Course
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                    <li class="px-1">
                        <a href="{{ route('admin.dashboard', ['tab' => 'companies']) }}"
                            class="font-bold text-sm {{ request('tab') == 'companies' || !request('tab') ? 'text-primary' : 'text-base-content/70' }} flex items-center gap-2">
                            <x-icon name="o-building-office" class="w-4 h-4" />
                            Companies
                        </a>
                    </li>
                    <li class="px-1">
                        <a href="{{ route('admin.dashboard', ['tab' => 'students']) }}"
                            class="font-bold text-sm {{ request('tab') == 'students' ? 'text-primary' : 'text-base-content/70' }} flex items-center gap-2">
                            <x-icon name="o-user-group" class="w-4 h-4" />
                            Students
                        </a>
                    </li>
                    <li class="px-1">
                        <a href="{{ route('admin.dashboard', ['tab' => 'jobs']) }}"
                            class="font-bold text-sm {{ request('tab') == 'jobs' ? 'text-primary' : 'text-base-content/70' }} flex items-center gap-2">
                            <x-icon name="o-briefcase" class="w-4 h-4" />
                            Jobs
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
                        <li><a href="{{ route('courses.index') }}">Courses</a></li>
                        <li><a href="{{ route('resources.index') }}">About Us</a></li>
                    @endif

                    @if($anyUser)
                        @if($company)
                            <li class="menu-title mt-2 text-primary">Company</li>
                            <li><a href="{{ route('company.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('applicants.index') }}">Applicants</a></li>
                            <li><a href="{{ route('jobs.create') }}">Post Job</a></li>
                            <li><a href="{{ route('company.profile') }}">Company Profile</a></li>
                        @elseif($admin)
                            <li class="menu-title mt-2 text-primary">Admin</li>
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="menu-title mt-2 text-primary">Student</li>
                            <li><a href="{{ route('profile') }}">My Profile</a></li>
                            <li><a href="{{ route('academia') }}">Research & Academia</a></li>
                        @endif
                        <div class="divider my-1"></div>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-error w-full text-left">Logout</button>
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
                        Student Login
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
                        <div class="w-10 rounded-full bg-base-300 flex items-center justify-center overflow-hidden">
                            @php
                                $profilePhoto = null;
                                if ($user && $user->studentProfile && $user->studentProfile->profile_photo_path) {
                                    $profilePhoto = Storage::url($user->studentProfile->profile_photo_path);
                                } elseif ($company && $company->logo_path) {
                                    $profilePhoto = asset('storage/' . $company->logo_path);
                                }
                            @endphp

                            @if($profilePhoto)
                                <img src="{{ $profilePhoto }}" alt="{{ $anyUser->name }}" class="w-full h-full object-cover" />
                            @elseif($anyUser->name)
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
                            <li><a href="{{ route('company.dashboard') }}"><x-icon name="o-squares-2x2" class="w-4 h-4" />
                                    Dashboard</a></li>
                            <li><a href="{{ route('company.profile') }}"><x-icon name="o-building-office" class="w-4 h-4" />
                                    Company Profile</a></li>

                        @elseif($admin)
                            <li><a href="{{ route('admin.dashboard') }}"><x-icon name="o-shield-check" class="w-4 h-4" /> Admin
                                    Panel</a></li>
                        @else
                            <li><a href="{{ route('profile') }}"><x-icon name="o-user" class="w-4 h-4" /> My Profile</a></li>
                            <li><a href="{{ route('academia') }}"><x-icon name="o-academic-cap" class="w-4 h-4" /> Research &
                                    Academia</a></li>
                        @endif

                        <div class="divider my-1"></div>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-error flex items-center gap-2 w-full text-left">
                                    <x-icon name="o-arrow-right-on-rectangle" class="w-4 h-4" />
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>