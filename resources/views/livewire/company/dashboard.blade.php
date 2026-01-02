<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-base-content">Company Dashboard</h1>
            <p class="text-base-content/70 mt-1">Manage your job postings and applications.</p>
        </div>
        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">
                <x-icon name="o-plus" class="w-4 h-4" />
                <span class="ml-2">Post New Job</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Jobs -->
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <x-icon name="o-briefcase" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-medium text-base-content/70">Total Posted Jobs</h3>
                    <p class="text-2xl font-bold">{{ $stats['total_jobs'] }}</p>
                </div>
            </div>
        </div>

        <!-- Active Jobs -->
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center text-success">
                    <x-icon name="o-check-circle" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-medium text-base-content/70">Active Listings</h3>
                    <p class="text-2xl font-bold">{{ $stats['active_jobs'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="card bg-base-100 shadow-sm border border-base-200">
            <div class="card-body flex-row items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
                    <x-icon name="o-users" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="text-base font-medium text-base-content/70">Total Applications</h3>
                    <p class="text-2xl font-bold">{{ $stats['total_applications'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Listings Table -->
    <div class="bg-base-100 border border-base-200 shadow-sm rounded-xl overflow-hidden">
        <div class="p-6 border-b border-base-200 bg-base-50/50 flex justify-between items-center">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <x-icon name="o-briefcase" class="w-5 h-5 text-primary" />
                Your Job Postings
            </h3>
        </div>

        @if($jobs->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead class="bg-base-200/50 text-base-content/70 uppercase text-xs font-bold">
                        <tr>
                            <th class="pl-6 py-4">Job Title</th>
                            <th class="py-4">Category</th>
                            <th class="py-4">Type</th>
                            <th class="py-4">Posted Date</th>
                            <th class="text-right pr-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-base divide-y divide-base-200">
                        @foreach($jobs as $job)
                            <tr class="hover:bg-base-200/50 transition-colors">
                                <td class="pl-6 py-4">
                                    <div class="font-bold">{{ $job->title }}</div>
                                    <div class="text-xs opacity-60 mt-1">{{ $job->location }}</div>
                                </td>
                                <td class="py-4">
                                    <div class="badge badge-ghost badge-sm">{{ $job->category }}</div>
                                </td>
                                <td class="py-4">
                                    <span class="badge badge-outline text-xs">{{ ucfirst($job->type) }}</span>
                                </td>
                                <td class="py-4">
                                    <div class="text-sm opacity-70">{{ $job->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="text-right pr-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('jobs.applications', $job->id) }}" 
                                            class="btn btn-ghost btn-sm btn-square text-base-content/70 hover:text-secondary hover:bg-secondary/10"
                                            title="View Applications">
                                            <div class="indicator">
                                                <x-icon name="o-users" class="w-5 h-5" />
                                                @if($job->applications_count > 0)
                                                    <span class="badge badge-xs badge-secondary indicator-item border-none w-2 h-2 p-0"></span>
                                                @endif
                                            </div>
                                        </a>
                                        <a href="{{ route('jobs.edit', $job->id) }}"
                                            class="btn btn-ghost btn-sm btn-square text-base-content/70 hover:text-primary hover:bg-primary/10"
                                            title="Edit Job">
                                            <x-icon name="o-pencil-square" class="w-5 h-5" />
                                        </a>
                                        <button wire:click="deleteJob({{ $job->id }})"
                                            wire:confirm="Are you sure you want to delete this job posting?"
                                            class="btn btn-ghost btn-sm btn-square text-error/70 hover:text-error hover:bg-error/10">
                                            <x-icon name="o-trash" class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($jobs->hasPages())
                <div class="p-4 border-t border-base-200 bg-base-50/50">
                    {{ $jobs->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16 bg-base-50/50">
                <div class="w-16 h-16 bg-base-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-icon name="o-briefcase" class="w-8 h-8 text-base-content/30" />
                </div>
                <h3 class="font-bold text-lg mb-1">No Active Jobs</h3>
                <p class="text-base-content/60 mb-6">You haven't posted any jobs yet.</p>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-sm">Post Your First Job</a>
            </div>
        @endif
    </div>

</div>