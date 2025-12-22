<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight">System Overview</h1>
            <p class="text-base-content/60 mt-1">Monitor site activity and manage approvals.</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="refreshStats" class="btn btn-ghost btn-sm gap-2">
                <x-icon name="o-arrow-path" class="w-4 h-4" />
                Refresh Data
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Users --}}
        <div class="stats shadow-sm border border-base-200 bg-base-100 w-full cursor-pointer hover:shadow-md transition-shadow" wire:click="setTab('companies')">
            <div class="stat">
                <div class="stat-figure text-primary bg-primary/10 p-2 rounded-xl">
                    <x-icon name="o-users" class="w-6 h-6" />
                </div>
                <div class="stat-title">Total Users</div>
                <div class="stat-value text-2xl">{{ $stats['total_users'] }}</div>
                <div class="stat-desc">Across all roles</div>
            </div>
        </div>

        {{-- Companies --}}
        <div class="stats shadow-sm border border-base-200 bg-base-100 w-full cursor-pointer hover:shadow-md transition-shadow" wire:click="setTab('companies')">
            <div class="stat">
                <div class="stat-figure text-secondary bg-secondary/10 p-2 rounded-xl">
                    <x-icon name="o-building-office-2" class="w-6 h-6" />
                </div>
                <div class="stat-title">Companies</div>
                <div class="stat-value text-2xl">{{ $stats['total_companies'] }}</div>
                <div class="stat-desc text-secondary font-bold">{{ $stats['pending_companies'] }} Pending Review</div>
            </div>
        </div>

        {{-- Active Jobs --}}
        <div class="stats shadow-sm border border-base-200 bg-base-100 w-full cursor-pointer hover:shadow-md transition-shadow" wire:click="setTab('jobs')">
            <div class="stat">
                <div class="stat-figure text-accent bg-accent/10 p-2 rounded-xl">
                    <x-icon name="o-briefcase" class="w-6 h-6" />
                </div>
                <div class="stat-title">Job Postings</div>
                <div class="stat-value text-2xl">{{ $stats['total_jobs'] }}</div>
                <div class="stat-desc">Live on site</div>
            </div>
        </div>

        {{-- Pending Actions --}}
        <div class="stats shadow-sm border border-base-200 bg-base-100 w-full cursor-pointer hover:shadow-md transition-shadow" wire:click="setTab('companies')">
            <div class="stat">
                <div class="stat-figure text-warning bg-warning/10 p-2 rounded-xl">
                    <x-icon name="o-clock" class="w-6 h-6" />
                </div>
                <div class="stat-title">Action Required</div>
                <div class="stat-value text-2xl text-warning">{{ $stats['pending_companies'] }}</div>
                <div class="stat-desc font-medium">New registrations</div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="tabs tabs-boxed bg-base-100 border border-base-200 p-1 w-fit">
        <button wire:click="setTab('companies')" class="tab tab-lg {{ $activeTab === 'companies' ? 'tab-active' : '' }} gap-2">
            <x-icon name="o-building-office" class="w-4 h-4" />
            Registrations
            @if($stats['pending_companies'] > 0)
                <span class="badge badge-sm badge-warning">{{ $stats['pending_companies'] }}</span>
            @endif
        </button>
        <button wire:click="setTab('jobs')" class="tab tab-lg {{ $activeTab === 'jobs' ? 'tab-active' : '' }} gap-2">
            <x-icon name="o-briefcase" class="w-4 h-4" />
            Job Postings
        </button>
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
            @if($activeTab === 'companies')
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
                        <div class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                            <x-icon name="o-check-badge" class="w-10 h-10 text-primary opacity-50" />
                        </div>
                        <h3 class="font-bold text-xl mb-1">All Caught Up!</h3>
                        <p class="text-base-content/60 max-w-sm mx-auto">There are no pending company registrations at the moment.</p>
                    </div>
                @endif

            @else
                {{-- Jobs Management Section --}}
                <div class="p-6 border-b border-base-200 bg-base-100">
                    <h3 class="font-bold text-lg flex items-center gap-2">
                        <x-icon name="o-briefcase" class="w-5 h-5 text-primary" />
                        Manage Job Postings
                    </h3>
                    <p class="text-sm text-base-content/60 mt-1">Monitor and moderate active job listings on the platform.</p>
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
                                                <div class="text-xs opacity-60">{{ $job->location }} • {{ ucfirst($job->type) }}</div>
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
                        <div class="bg-base-200 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-base-100 shadow-sm">
                            <x-icon name="o-briefcase" class="w-10 h-10 text-primary opacity-50" />
                        </div>
                        <h3 class="font-bold text-xl mb-1">No Jobs Found</h3>
                        <p class="text-base-content/60 max-w-sm mx-auto">There are currently no job postings on the platform.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>