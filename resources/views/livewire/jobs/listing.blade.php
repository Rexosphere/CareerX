<?php
use Livewire\Volt\Component;

new class extends Component {
    public string $search = '';
    public string $sortBy = 'newest';
    public array $jobTypes = [];
    public int $salaryMin = 0;
    public array $industries = [];
    public ?int $selectedJob = null;

    public function with(): array
    {
        // Query active job postings from database
        $jobs = \App\Models\JobPosting::query()
            ->where('is_active', true)
            ->latest()
            ->get()
            ->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company_name,
                    'industry' => $job->category,
                    'logo' => $job->company_logo ?? 'https://ui-avatars.com/api/?name=' . urlencode($job->company_name),
                    'type' => $job->type,
                    'workMode' => 'Hybrid', // You can add this field to DB later
                    'location' => $job->location,
                    'salary' => $job->salary_range ?? 'Negotiable',
                    'postedDays' => $job->created_at->diffInDays(),
                ];
            })
            ->toArray();

        return [
            'jobs' => $jobs,
            'jobCount' => count($jobs),
        ];
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->jobTypes = [];
        $this->salaryMin = 0;
        $this->industries = [];
    }

    public function showJobDetails(int $jobId): void
    {
        $this->selectedJob = $jobId;
        $this->dispatch('open-job-modal', jobId: $jobId);
    }
}; ?>

<div class="flex flex-col lg:flex-row gap-8">
    <!-- Left Sidebar: Filters -->
    <aside class="w-full lg:w-72 flex-shrink-0 space-y-6">
        <!-- Search Filter -->
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold">Search</h3>
                    <button wire:click="clearFilters" class="text-xs text-primary font-medium hover:underline">Clear</button>
                </div>
                <label class="input input-bordered flex items-center gap-2">
                    <x-icon name="o-magnifying-glass" class="w-5 h-5 text-base-content/60" />
                    <input wire:model.live="search" type="text" class="grow" placeholder="Keywords (e.g. Java)" />
                </label>
            </div>
        </div>

        <!-- Filter Accordions -->
        <div class="card bg-base-100 border border-base-300 shadow-sm overflow-hidden">
            <!-- Job Type -->
            <div class="collapse collapse-arrow border-b border-base-300">
                <input type="checkbox" checked />
                <div class="collapse-title text-sm font-bold">Job Type</div>
                <div class="collapse-content">
                    <div class="space-y-3">
                        <label class="label cursor-pointer justify-start gap-3 py-1">
                            <input wire:model.live="jobTypes" type="checkbox" value="Full Time" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Full Time</span>
                            <span class="ml-auto text-xs text-base-content/40">24</span>
                        </label>
                        <label class="label cursor-pointer justify-start gap-3 py-1">
                            <input wire:model.live="jobTypes" type="checkbox" value="Internship" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Internship</span>
                            <span class="ml-auto text-xs text-base-content/40">12</span>
                        </label>
                        <label class="label cursor-pointer justify-start gap-3 py-1">
                            <input wire:model.live="jobTypes" type="checkbox" value="Part Time" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Part Time</span>
                            <span class="ml-auto text-xs text-base-content/40">6</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Salary Range -->
            <div class="collapse collapse-arrow border-b border-base-300">
                <input type="checkbox" checked />
                <div class="collapse-title text-sm font-bold">Salary Expectations</div>
                <div class="collapse-content">
                    <div class="flex items-center justify-between text-xs text-base-content/60 mb-2">
                        <span>LKR 0</span>
                        <span>LKR 500k+</span>
                    </div>
                    <input wire:model.live="salaryMin" type="range" min="0" max="100" class="range range-primary range-sm" />
                    <div class="mt-3 text-sm font-medium text-primary text-center bg-primary/5 rounded py-1 border border-primary/10">
                        > LKR {{ number_format($salaryMin * 1200) }} / mo
                    </div>
                </div>
            </div>

            <!-- Industry -->
            <div class="collapse collapse-arrow">
                <input type="checkbox" />
                <div class="collapse-title text-sm font-bold">Industry</div>
                <div class="collapse-content">
                    <div class="space-y-3">
                        <label class="label cursor-pointer justify-start gap-3 py-1">
                            <input wire:model.live="industries" type="checkbox" value="Software Engineering" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Software Engineering</span>
                        </label>
                        <label class="label cursor-pointer justify-start gap-3 py-1">
                            <input wire:model.live="industries" type="checkbox" value="Data Science" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Data Science</span>
                        </label>
                        <label class="label cursor-pointer justify-start gap-3 py-1">
                            <input wire:model.live="industries" type="checkbox" value="Design" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Design</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reset Button -->
        <button wire:click="clearFilters" class="btn btn-outline btn-block">
            Reset All Filters
        </button>
    </aside>

    <!-- Right Content: Job Listings -->
    <div class="flex-1 min-w-0">
        <!-- Controls Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <span class="text-sm text-base-content/70 font-medium">Showing {{ $jobCount }} jobs</span>
            <div class="flex items-center gap-3">
                <div class="divider divider-horizontal hidden sm:flex"></div>
                <select wire:model.live="sortBy" class="select select-bordered select-sm">
                    <option value="newest">Sort: Newest</option>
                    <option value="oldest">Sort: Oldest</option>
                    <option value="salary-high">Sort: Salary (High)</option>
                    <option value="salary-low">Sort: Salary (Low)</option>
                </select>
            </div>
        </div>

        <!-- Global Search -->
        <div class="mb-6">
            <label class="input input-bordered flex items-center gap-2 shadow-sm">
                <x-icon name="o-magnifying-glass" class="w-5 h-5 text-base-content/60" />
                <input wire:model.live="search" type="text" class="grow" placeholder="Search by job title, company, or keywords..." />
            </label>
        </div>

        <!-- Job Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            @forelse($jobs as $job)
                <div wire:key="job-{{ $job['id'] }}" class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img src="{{ $job['logo'] }}" alt="{{ $job['company'] }} Logo" class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold hover:text-primary transition-colors">{{ $job['title'] }}</h3>
                                    <p class="text-sm font-medium text-base-content/70">{{ $job['company'] }} • {{ $job['industry'] }}</p>
                                </div>
                            </div>
                            <button class="text-base-content/30 hover:text-error transition-colors">
                                <x-icon name="o-heart" class="w-5 h-5" />
                            </button>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="badge badge-primary badge-sm">{{ $job['type'] }}</span>
                            <span class="badge badge-secondary badge-sm">{{ $job['workMode'] }}</span>
                        </div>

                        <!-- Details -->
                        <div class="flex flex-col gap-2 mb-6">
                            <div class="flex items-center gap-2 text-sm text-base-content/70">
                                <x-icon name="o-map-pin" class="w-[18px] h-[18px]" />
                                <span>{{ $job['location'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-base-content/70">
                                <x-icon name="o-currency-dollar" class="w-[18px] h-[18px]" />
                                <span>{{ $job['salary'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-base-content/70">
                                <x-icon name="o-clock" class="w-[18px] h-[18px]" />
                                <span>Posted {{ isset($job['postedHours']) ? $job['postedHours'] . ' hours' : $job['postedDays'] . ' days' }} ago</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="card-actions pt-4 border-t border-base-300">
                            <button wire:click="showJobDetails({{ $job['id'] }})" class="btn btn-primary btn-outline btn-block btn-sm">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="max-w-md mx-auto flex flex-col items-center p-8 bg-base-100 rounded-xl border border-base-300 shadow-sm text-center">
                        <div class="w-48 h-32 mb-6 bg-primary/10 rounded-full flex items-center justify-center">
                            <x-icon name="o-magnifying-glass-minus" class="text-primary/40 w-16 h-16" />
                        </div>
                        <h3 class="text-lg font-bold mb-2">No jobs found</h3>
                        <p class="text-base-content/70 text-sm mb-6">
                            We couldn't find any jobs matching your current filters. Try adjusting your search keywords or clearing some filters.
                        </p>
                        <button wire:click="clearFilters" class="btn btn-primary btn-sm">
                            Clear All Filters
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Load More -->
        @if($jobCount > 0)
            <div class="flex justify-center">
                <button class="btn btn-outline gap-2">
                    <span>Load More Jobs</span>
                    <x-icon name="o-arrow-down" class="w-4 h-4" />
                </button>
            </div>
        @endif
    </div>
</div>
