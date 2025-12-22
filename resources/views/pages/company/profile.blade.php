<x-layouts.main title="{{ $user->name }} - Profile">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-base-content/70">{{ $user->email }}</p>
                <div class="flex gap-2 mt-2">
                    <span class="badge badge-primary">Employer Account</span>
                    <span class="badge badge-neutral">Member since {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="#" class="btn btn-neutral btn-sm">Edit Profile</a>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-sm">
                    <x-icon name="o-plus" class="w-4 h-4" />
                    Post New Job
                </a>
            </div>
        </div>

        <div class="divider"></div>

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Your Job Listings</h2>
            <div class="text-sm text-base-content/70">
                You have posted {{ $jobs->count() }} jobs
            </div>
        </div>

        @if($jobs->isEmpty())
            <div
                class="flex flex-col items-center justify-center py-16 bg-base-200/50 rounded-box border border-base-300 border-dashed">
                <div class="p-4 bg-base-200 rounded-full mb-4">
                    <x-icon name="o-briefcase" class="w-8 h-8 opacity-50" />
                </div>
                <h3 class="text-lg font-bold mb-1">No job listings yet</h3>
                <p class="text-base-content/60 mb-6 text-center max-w-md">Creates your first job listing to start receiving
                    applications from talented candidates.</p>
                <a href="{{ route('jobs.create') }}" class="btn btn-primary">Create Job Listing</a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($jobs as $job)
                    <div class="card bg-base-100 shadow-sm border border-base-200 hover:border-primary/50 transition-colors">
                        <div class="card-body p-6">
                            <div class="flex flex-col md:flex-row justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-xl font-bold hover:text-primary transition-colors">
                                            <a href="#">{{ $job->title }}</a>
                                        </h3>
                                        @if($job->is_active)
                                            <span class="badge badge-success badge-sm badge-outline">Active</span>
                                        @else
                                            <span class="badge badge-ghost badge-sm badge-outline">Closed</span>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-base-content/70 mb-3">
                                        <span class="flex items-center gap-1">
                                            <x-icon name="o-map-pin" class="w-4 h-4" />
                                            {{ $job->location ?? 'Remote' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <x-icon name="o-clock" class="w-4 h-4" />
                                            Posted {{ $job->created_at->diffForHumans() }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <x-icon name="o-banknotes" class="w-4 h-4" />
                                            {{ $job->salary_range ?? 'Not specified' }}
                                        </span>
                                    </div>

                                    <p class="text-base-content/80 line-clamp-2">{{ Str::limit($job->description, 200) }}</p>
                                </div>

                                <div class="flex flex-row md:flex-col gap-2 md:items-end justify-start">
                                    <a href="#" class="btn btn-sm btn-outline">Edit</a>
                                    <a href="#" class="btn btn-sm btn-ghost hover:bg-error/10 hover:text-error">Delete</a>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-base-200 flex justify-between items-center text-sm">
                                <div class="flex gap-2">
                                    <div class="badge badge-neutral badge-outline">{{ $job->type ?? 'Full-time' }}</div>
                                    <div class="badge badge-neutral badge-outline">{{ $job->category ?? 'General' }}</div>
                                </div>
                                <a href="#" class="link link-hover text-primary font-medium text-sm">View Applications
                                    ({{ $job->applications_count ?? 0 }})</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.main>