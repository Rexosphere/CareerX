<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">
                @if($activeTab === 'overview') System Overview
                @elseif($activeTab === 'companies') Company Registrations
                @elseif($activeTab === 'courses') Course Management
                @elseif($activeTab === 'jobs') Job Postings
                @elseif($activeTab === 'students') Student Directory
                @endif
            </h1>
            <p class="text-base-content/60 mt-1">
                @if($activeTab === 'overview') Monitor site activity and manage approvals.
                @elseif($activeTab === 'companies') Review and approve new company accounts.
                @elseif($activeTab === 'courses') Create and manage educational content.
                @elseif($activeTab === 'jobs') Monitor and moderate active job listings.
                @elseif($activeTab === 'students') View and manage registered students.
                @endif
            </p>
        </div>
        <div class="flex gap-2">
            <button wire:click="refreshStats" class="btn btn-ghost btn-sm gap-2">
                <x-icon name="o-arrow-path" class="w-4 h-4" />
                Refresh Data
            </button>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success shadow-sm">
            <x-icon name="o-check-circle" class="w-6 h-6" />
            <span>{{ session('message') }}</span>
        </div>
    @endif

    {{-- Content Section --}}
    <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
        <div class="card-body p-0">
            @if($activeTab === 'overview')
                {{-- Overview / Stats Section --}}
                <div class="p-8 space-y-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold flex items-center gap-3">
                                <x-icon name="o-squares-2x2" class="w-7 h-7 text-primary" />
                                Admin Overview
                            </h2>
                            <p class="text-base-content/60 mt-1">Quick summary of the system's performance and activity.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Total Students --}}
                        <div class="stats shadow-sm border border-base-200 bg-base-100/50 hover:border-primary/30 transition-all cursor-pointer group"
                            wire:click="setTab('students')">
                            <div class="stat">
                                <div
                                    class="stat-figure text-primary bg-primary/10 p-3 rounded-2xl group-hover:scale-110 transition-transform">
                                    <x-icon name="o-user-group" class="w-7 h-7" />
                                </div>
                                <div class="stat-title font-medium">Total Students</div>
                                <div class="stat-value text-3xl">{{ $stats['total_students'] }}</div>
                                <div class="stat-desc mt-1">Growth: +2 this week</div>
                            </div>
                        </div>

                        {{-- Companies --}}
                        <div class="stats shadow-sm border border-base-200 bg-base-100/50 hover:border-secondary/30 transition-all cursor-pointer group"
                            wire:click="setTab('companies')">
                            <div class="stat">
                                <div
                                    class="stat-figure text-secondary bg-secondary/10 p-3 rounded-2xl group-hover:scale-110 transition-transform">
                                    <x-icon name="o-building-office-2" class="w-7 h-7" />
                                </div>
                                <div class="stat-title font-medium">Partner Companies</div>
                                <div class="stat-value text-3xl">{{ $stats['total_companies'] }}</div>
                                <div class="stat-desc mt-1 text-secondary font-bold">{{ $stats['pending_companies'] }}
                                    Pending Review</div>
                            </div>
                        </div>

                        {{-- Courses --}}
                        <div class="stats shadow-sm border border-base-200 bg-base-100/50 hover:border-accent/30 transition-all cursor-pointer group"
                            wire:click="setTab('courses')">
                            <div class="stat">
                                <div
                                    class="stat-figure text-accent bg-accent/10 p-3 rounded-2xl group-hover:scale-110 transition-transform">
                                    <x-icon name="o-academic-cap" class="w-7 h-7" />
                                </div>
                                <div class="stat-title font-medium">Active Courses</div>
                                <div class="stat-value text-3xl">{{ $stats['total_courses'] }}</div>
                                <div class="stat-desc mt-1">Across 4 categories</div>
                            </div>
                        </div>

                        {{-- Active Jobs --}}
                        <div class="stats shadow-sm border border-base-200 bg-base-100/50 hover:border-info/30 transition-all cursor-pointer group"
                            wire:click="setTab('jobs')">
                            <div class="stat">
                                <div
                                    class="stat-figure text-info bg-info/10 p-3 rounded-2xl group-hover:scale-110 transition-transform">
                                    <x-icon name="o-briefcase" class="w-7 h-7" />
                                </div>
                                <div class="stat-title font-medium">Job Listings</div>
                                <div class="stat-value text-3xl">{{ $stats['total_jobs'] }}</div>
                                <div class="stat-desc mt-1">Active postings</div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Action Card --}}
                    @if($stats['pending_companies'] > 0)
                        <div class="alert bg-warning/10 border-warning/20 shadow-sm flex justify-between items-center p-6">
                            <div class="flex items-center gap-4">
                                <div class="bg-warning text-warning-content p-3 rounded-full">
                                    <x-icon name="o-exclamation-triangle" class="w-6 h-6" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">Action Required!</h4>
                                    <p class="text-sm opacity-70">There are {{ $stats['pending_companies'] }} company
                                        registrations waiting for your approval.</p>
                                </div>
                            </div>
                            <button wire:click="setTab('companies')" class="btn btn-warning shadow-md">Review Now</button>
                        </div>
                    @endif
                </div>

            @elseif($activeTab === 'companies')
                {{-- Pending Companies Section --}}
                <div class="p-6 border-b border-base-200 bg-base-100">
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <x-icon name="o-clipboard-document-check" class="w-5 h-5 text-primary" />
                        Company Registration Requests
                    </h3>
                    <p class="text-sm text-base-content/60 mt-1">Review and approve new company accounts.</p>
                </div>

                @if($pendingCompanies->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-zebra table-lg">
                            <thead>
                                <tr class="bg-base-200/50 text-base-content">
                                    <th class="pl-6">Company Info</th>
                                    <th>Contact Information</th>
                                    <th>Registered</th>
                                    <th class="text-right pr-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingCompanies as $company)
                                    <tr wire:key="company-{{ $company->id }}" class="hover:bg-base-200/30 transition-colors">
                                        <td class="pl-6">
                                            <div class="flex items-center gap-4">
                                                <div class="avatar placeholder">
                                                    <div class="bg-primary text-primary-content rounded-xl w-12 h-12 shadow-sm">
                                                        <span class="text-lg font-bold">{{ $company->initials() }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-base">{{ $company->name }}</div>
                                                    <div class="text-xs opacity-60">ID: #{{ $company->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex flex-col">
                                                <div class="font-medium">{{ $company->email }}</div>
                                                <div class="text-xs opacity-60 flex items-center gap-1 mt-0.5">
                                                    <x-icon name="o-envelope" class="w-3 h-3" />
                                                    Verified: {{ $company->email_verified_at ? 'Yes' : 'No' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-ghost badge-sm gap-1 text-nowrap">
                                                <x-icon name="o-calendar" class="w-3 h-3" />
                                                {{ $company->created_at->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="text-right pr-6">
                                            <div class="flex justify-end gap-2">
                                                <button wire:click="reject({{ $company->id }})"
                                                    wire:confirm="Are you sure you want to reject {{ $company->name }}? This action cannot be undone."
                                                    class="btn btn-error btn-outline btn-sm shadow-sm">
                                                    <x-icon name="o-x-mark" class="w-4 h-4" />
                                                    Reject
                                                </button>
                                                <button wire:click="approve({{ $company->id }})"
                                                    wire:confirm="Approve access for {{ $company->name }}?"
                                                    class="btn btn-success text-white btn-sm shadow-sm">
                                                    <x-icon name="o-check" class="w-4 h-4" />
                                                    Approve
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="p-4 border-t border-base-200 bg-base-50">
                        {{ $pendingCompanies->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-base-50/50">
                        <div
                            class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                            <x-icon name="o-check-badge" class="w-10 h-10 text-primary opacity-50" />
                        </div>
                        <h3 class="font-bold text-xl mb-1">All Caught Up!</h3>
                        <p class="text-base-content/60 max-w-sm mx-auto">There are no pending company registrations at the
                            moment.</p>
                    </div>
                @endif
            @elseif($activeTab === 'courses')
                {{-- Courses Management Section --}}
                <div class="p-8 space-y-8 bg-base-200/20 min-h-[600px]">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold flex items-center gap-3">
                                <x-icon name="o-academic-cap" class="w-7 h-7 text-primary" />
                                @if ($courseSubTab === 'form')
                                    Create New Course
                                @else
                                    Course Directory
                                @endif
                            </h2>
                            <p class="text-base-content/60 mt-1">
                                @if ($courseSubTab === 'form')
                                    Design and publish learning materials for your students.
                                @else
                                    Manage and review all published educational content.
                                @endif
                            </p>
                        </div>
                        {{-- Sub-tab Toggle --}}
                        <div class="join bg-base-100 shadow-sm border border-base-200">
                            <button wire:click="setCourseSubTab('list')"
                                class="join-item btn btn-sm {{ $courseSubTab === 'list' ? 'btn-primary' : 'btn-ghost' }} gap-2">
                                <x-icon name="o-list-bullet" class="w-4 h-4" />
                                View List
                            </button>
                            <button wire:click="setCourseSubTab('form')"
                                class="join-item btn btn-sm {{ $courseSubTab === 'form' ? 'btn-primary' : 'btn-ghost' }} gap-2">
                                <x-icon name="o-plus-circle" class="w-4 h-4" />
                                Add Course
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-10">
                        @if ($courseSubTab === 'form')
                            <!-- Add Course Form Card -->
                            <div
                                class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                                <div class="p-6 border-b border-base-200 bg-base-100/50">
                                    <h3 class="font-bold text-lg flex items-center gap-2 text-primary">
                                        <x-icon name="o-plus-circle" class="w-5 h-5" />
                                        Course Details
                                    </h3>
                                </div>
                                <div class="card-body p-6">
                                    <div class="max-w-3xl mx-auto w-full">
                                        <form wire:submit.prevent="addCourse" class="flex flex-col gap-y-10">
                                            {{-- Course Title --}}
                                            <div class="form-control items-start">
                                                <label class="label mb-2">
                                                    <span
                                                        class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                                        <x-icon name="o-pencil-square" class="w-4 h-4 text-primary" />
                                                        Course Title
                                                    </span>
                                                </label>
                                                <input type="text" wire:model="course_title"
                                                    class="input input-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300"
                                                    placeholder="e.g. Master Interview Preparation Guide" />
                                                @error('course_title')
                                                    <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Category --}}
                                            <div class="form-control items-start">
                                                <label class="label mb-2">
                                                    <span
                                                        class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                                        <x-icon name="o-tag" class="w-4 h-4 text-primary" />
                                                        Category
                                                    </span>
                                                </label>
                                                <select wire:model="course_category"
                                                    class="select select-bordered w-full bg-base-50/30 focus:bg-base-100 focus:border-primary transition-all duration-300">
                                                    @foreach(\App\Livewire\Admin\Dashboard::COURSE_CATEGORIES as $category)
                                                        <option value="{{ $category }}">{{ $category }}</option>
                                                    @endforeach
                                                </select>
                                                @error('course_category')
                                                    <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- Course Content (YouTube URL) --}}
                                            <div class="form-control items-start w-full">
                                                <label class="label mb-2">
                                                    <span
                                                        class="label-text font-bold text-base-content/80 flex items-center gap-2">
                                                        <x-icon name="o-video-camera" class="w-4 h-4 text-primary" />
                                                        YouTube Video URL
                                                    </span>
                                                </label>
                                                <input type="url" wire:model="course_content"
                                                    class="input input-bordered w-full bg-base-50/30 transition-all duration-300"
                                                    placeholder="https://www.youtube.com/watch?v=..." />
                                                <label class="label">
                                                    <span class="label-text-alt text-base-content/60">Paste the full YouTube
                                                        video URL here.</span>
                                                </label>
                                                @error('course_content')
                                                    <span class="text-error text-xs mt-1 font-medium">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="flex flex-col items-center self-end gap-6">
                                                <button type="submit"
                                                    class="btn btn-primary px-20 shadow-lg hover:shadow-primary/20 transition-all gap-2 h-14 text-lg">
                                                    <x-icon name="o-paper-airplane" class="w-5 h-5 -rotate-45" />
                                                    Publish Course
                                                </button>
                                                <div class="text-sm text-base-content/50 italic flex items-center gap-2">
                                                    <x-icon name="o-information-circle" class="w-4 h-4" />
                                                    Course will be visible to all registered students.
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Courses List Section -->
                            <div
                                class="card bg-base-100 shadow-sm border border-base-200 overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-500">
                                <div class="p-6 border-b border-base-200 bg-base-100/50 flex justify-between items-center">
                                    <h3 class="font-bold text-lg flex items-center gap-2">
                                        <x-icon name="o-list-bullet" class="w-5 h-5 text-primary" />
                                        Published Courses
                                    </h3>
                                    <div class="badge badge-primary badge-soft">{{ $courses->total() }} Total</div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="table table-zebra table-lg">
                                        <thead class="bg-base-200/50 text-base-content uppercase text-xs tracking-wider">
                                            <tr>
                                                <th class="pl-8 py-5">Course Details</th>
                                                <th class="py-5">Category</th>
                                                <th class="py-5">Posted Date</th>
                                                <th class="text-right pr-8 py-5">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-base-200">
                                            @forelse ($courses as $course)
                                                <tr wire:key="course-{{ $course->id }}"
                                                    class="hover:bg-base-200/40 transition-all group">
                                                    <td class="pl-8 py-4">
                                                        <div class="font-bold text-base text-primary group-hover:underline">
                                                            {{ $course->title }}
                                                        </div>
                                                        <div class="text-sm opacity-60 line-clamp-1 max-w-xl mt-1">
                                                            {{ $course->content }}
                                                        </div>
                                                    </td>
                                                    <td class="py-4">
                                                        <div class="badge badge-outline border-base-300 font-medium font-sans">
                                                            {{ $course->category }}
                                                        </div>
                                                    </td>
                                                    <td class="py-4">
                                                        <div class="flex items-center gap-2 text-sm opacity-70">
                                                            <x-icon name="o-calendar" class="w-4 h-4" />
                                                            {{ $course->created_at->format('M d, Y') }}
                                                        </div>
                                                    </td>
                                                    <td class="text-right pr-8 py-4">
                                                        <button wire:click="deleteCourse({{ $course->id }})"
                                                            wire:confirm="Are you sure you want to permanently delete '{{ $course->title }}'?"
                                                            class="btn btn-error btn-ghost btn-sm text-error/70 hover:text-error hover:bg-error/10 p-2">
                                                            <x-icon name="o-trash" class="w-5 h-5" />
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-20 bg-base-50/20">
                                                        <div class="flex flex-col items-center gap-4 opacity-40">
                                                            <x-icon name="o-academic-cap" class="w-16 h-16" />
                                                            <p class="text-lg font-medium">No courses published yet.</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if ($courses->hasPages())
                                    <div class="p-6 border-t border-base-200 bg-base-50/50">
                                        {{ $courses->links() }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($activeTab === 'jobs')
                {{-- Jobs Management Section --}}
                <div class="p-6 border-b border-base-200 bg-base-100">
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <x-icon name="o-briefcase" class="w-5 h-5 text-primary" />
                        Manage Job Postings
                    </h3>
                    <p class="text-sm text-base-content/60 mt-1">Monitor and moderate active job listings on the platform.
                    </p>
                </div>

                @if($jobs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-zebra table-lg">
                            <thead>
                                <tr class="bg-base-200/50 text-base-content">
                                    <th class="pl-6">Job Title</th>
                                    <th>Posted By</th>
                                    <th>Category</th>
                                    <th>Posted Date</th>
                                    <th class="text-right pr-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr wire:key="job-{{ $job->id }}" class="hover:bg-base-200/30 transition-colors">
                                        <td class="pl-6">
                                            <div>
                                                <div class="font-bold text-base">{{ $job->title }}</div>
                                                <div class="text-xs opacity-60">{{ $job->location }} • {{ ucfirst($job->type) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                @if($job->company)
                                                    <div class="font-medium">{{ $job->company->name }}</div>
                                                @else
                                                    <div class="italic text-base-content/50">Unknown Company</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-outline badge-md text-nowrap">{{ $job->category }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm opacity-70">{{ $job->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="text-right pr-6">
                                            <div class="flex justify-end gap-2">
                                                <button wire:click="deleteJob({{ $job->id }})"
                                                    wire:confirm="Permanently delete this job posting? This action cannot be undone."
                                                    class="btn btn-error btn-ghost btn-sm text-error">
                                                    <x-icon name="o-trash" class="w-4 h-4" />
                                                    Delete
                                                </button>
                                                <a href="{{ route('jobs.index') }}" class="btn btn-ghost btn-sm gap-2">
                                                    <x-icon name="o-eye" class="w-4 h-4" />
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="p-4 border-t border-base-200 bg-base-50">
                        {{ $jobs->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-base-50/50">
                        <div
                            class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                            <x-icon name="o-briefcase" class="w-10 h-10 text-primary opacity-50" />
                        </div>
                        <h3 class="font-bold text-xl mb-1">No Jobs Found</h3>
                        <p class="text-base-content/60 max-w-sm mx-auto">There are currently no job postings on the platform.
                        </p>
                    </div>
                @endif
            @elseif($activeTab === 'students')
                {{-- Students Management Section --}}
                <div
                    class="p-6 border-b border-base-200 bg-base-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="font-bold text-lg flex items-center gap-2">
                            <x-icon name="o-user-group" class="w-5 h-5 text-primary" />
                            Manage Students
                        </h3>
                        <p class="text-sm text-base-content/60 mt-1">View and monitor registered students on the platform.
                        </p>
                    </div>
                    <div class="form-control w-full sm:w-auto">
                        <div class="input-group">
                            <input type="text" wire:model.live.debounce.300ms="studentSearch"
                                placeholder="Search by name or email..."
                                class="input input-bordered input-sm w-full sm:w-64" />
                        </div>
                    </div>
                </div>

                @if ($students->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-zebra table-lg">
                            <thead>
                                <tr class="bg-base-200/50 text-base-content">
                                    <th class="pl-6">Student Info</th>
                                    <th>Email</th>
                                    <th>Registered</th>
                                    <th>Status</th>
                                    <th class="text-right pr-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr wire:key="student-{{ $student->id }}" class="hover:bg-base-200/30 transition-colors">
                                        <td class="pl-6">
                                            <div class="flex items-center gap-4">
                                                <div class="avatar placeholder">
                                                    <div class="bg-accent text-accent-content rounded-xl w-10 h-10 shadow-sm">
                                                        <span class="text-sm font-bold">{{ $student->initials() }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-base">{{ $student->name }}</div>
                                                    <div class="text-xs opacity-60">ID: #{{ $student->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-medium">{{ $student->email }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm opacity-70">{{ $student->created_at->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-success badge-sm">Active</div>
                                        </td>
                                        <td class="text-right pr-6">
                                            <button wire:click="deleteStudent({{ $student->id }})"
                                                wire:confirm="Are you sure you want to delete this student account? This action cannot be undone."
                                                class="btn btn-error btn-ghost btn-sm text-error/70 hover:text-error hover:bg-error/10 p-1">
                                                <x-icon name="o-trash" class="w-4 h-4" />
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="p-4 border-t border-base-200 bg-base-50">
                        {{ $students->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-base-50/50">
                        <div
                            class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                            <x-icon name="o-user" class="w-10 h-10 text-primary opacity-50" />
                        </div>
                        <h3 class="font-bold text-xl mb-1">No Students Yet</h3>
                        <p class="text-base-content/60 max-w-sm mx-auto">There are no registered students in the system.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>