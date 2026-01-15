<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url(as: 'search')]
    public string $search = '';

    #[Url(as: 'category')]
    public string $category = '';

    #[Url(as: 'location')]
    public string $location = '';

    public string $sortBy = 'newest';
    public array $jobTypes = [];
    public int $salaryMin = 0;
    public array $industries = [];
    public ?int $selectedJob = null;
    public int $perPage = 10;
    public array $savedJobIds = [];
    public array $appliedJobIds = [];

    public function mount(): void
    {
        // Load saved job IDs and applied job IDs for the current user
        if (auth('web')->check() && auth('web')->user()->isStudent()) {
            $this->savedJobIds = auth('web')->user()->savedJobs()
                ->pluck('job_posting_id')
                ->toArray();
            
            $this->appliedJobIds = auth('web')->user()->applications()
                ->pluck('job_id')
                ->toArray();
        }
    }

    public function with(): array
    {
        // Build the query with filters
        $query = \App\Models\JobPosting::query()
            ->with('company')
            ->where('is_active', true);

        // Search filter - search in title, company name, description, and location
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('company_name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhere('location', 'like', $searchTerm);
            });
        }

        // Category filter (from homepage search bar)
        if (!empty($this->category)) {
            $query->where('category', 'like', '%' . $this->category . '%');
        }

        // Location filter (from homepage search bar)
        if (!empty($this->location)) {
            $query->where('location', 'like', '%' . $this->location . '%');
        }

        // Job type filter (checkboxes)
        if (!empty($this->jobTypes)) {
            $query->whereIn('type', $this->jobTypes);
        }

        // Industry filter (checkboxes)
        if (!empty($this->industries)) {
            $query->whereIn('category', $this->industries);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'salary-high':
                $query->orderByRaw("CAST(REPLACE(REPLACE(salary_range, 'LKR', ''), ',', '') AS UNSIGNED) DESC");
                break;
            case 'salary-low':
                $query->orderByRaw("CAST(REPLACE(REPLACE(salary_range, 'LKR', ''), ',', '') AS UNSIGNED) ASC");
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $totalJobs = (clone $query)->count();
        $jobs = $query->take($this->perPage)->get()
            ->map(function ($job) {
                // Use current company logo from profile if available, otherwise fall back to stored logo or avatar
                $logo = null;
                if ($job->company && $job->company->logo_path) {
                    $logo = asset('storage/' . $job->company->logo_path);
                } elseif ($job->company_logo) {
                    $logo = $job->company_logo;
                } else {
                    $logo = 'https://ui-avatars.com/api/?name=' . urlencode($job->company_name);
                }

                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company_name,
                    'industry' => $job->category,
                    'logo' => $logo,
                    'type' => $job->type,
                    'workMode' => 'Hybrid', // You can add this field to DB later
                    'location' => $job->location,
                    'salary' => $job->salary_range ?? 'Negotiable',
                    'postedDays' => (int) $job->created_at->diffInDays(),
                    'hasApplied' => in_array($job->id, $this->appliedJobIds),
                ];
            })
            ->toArray();

        return [
            'jobs' => $jobs,
            'jobCount' => count($jobs),
            'totalJobs' => $totalJobs,
            'hasMoreJobs' => count($jobs) < $totalJobs,
            'jobTypeCounts' => $this->getJobTypeCounts(),
            'availableCategories' => $this->getAvailableCategories(),
        ];
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->category = '';
        $this->location = '';
        $this->jobTypes = [];
        $this->salaryMin = 0;
        $this->industries = [];
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
    }

    public function toggleSaveJob(int $jobId): void
    {
        if (!auth('web')->check()) {
            session()->flash('error', 'Please login to save jobs.');
            $this->redirectRoute('login');
            return;
        }

        if (!auth('web')->user()->isStudent()) {
            session()->flash('error', 'Only students can save jobs.');
            return;
        }

        $job = \App\Models\JobPosting::find($jobId);
        if (!$job) {
            session()->flash('error', 'Job not found.');
            return;
        }

        // Toggle save/unsave
        $existingSave = auth('web')->user()->savedJobs()
            ->where('job_posting_id', $jobId)
            ->first();

        if ($existingSave) {
            $existingSave->delete();
            $this->savedJobIds = array_values(array_diff($this->savedJobIds, [$jobId]));
            session()->flash('message', 'Job removed from saved jobs.');
        } else {
            auth('web')->user()->savedJobs()->create([
                'job_posting_id' => $jobId,
            ]);
            $this->savedJobIds[] = $jobId;
            session()->flash('message', 'Job saved successfully!');
        }
    }

    public function isJobSaved(int $jobId): bool
    {
        return in_array($jobId, $this->savedJobIds);
    }

    protected function getJobTypeCounts(): array
    {
        return \App\Models\JobPosting::query()
            ->where('is_active', true)
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }

    protected function getAvailableCategories(): array
    {
        return \App\Models\JobPosting::query()
            ->where('is_active', true)
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();
    }

    public function showJobDetails(int $jobId): void
    {
        $this->selectedJob = $jobId;
        $this->dispatch('open-job-modal', jobId: $jobId);
    }

    #[Livewire\Attributes\On('application-submitted')]
    public function refreshAppliedJobs(?int $jobId = null): void
    {
        // Add the newly applied job ID to the list
        if ($jobId && !in_array($jobId, $this->appliedJobIds)) {
            $this->appliedJobIds[] = $jobId;
        }
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
                    <button wire:click="clearFilters"
                        class="text-xs text-primary font-medium hover:underline">Clear</button>
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
                        @php
                            $jobTypeOptions = ['Full Time', 'Part Time', 'Internship', 'Contract', 'Remote'];
                        @endphp
                        @foreach($jobTypeOptions as $type)
                            @if(isset($jobTypeCounts[$type]) || in_array($type, ['Full Time', 'Part Time', 'Internship']))
                                <label class="label cursor-pointer justify-start gap-3 py-1">
                                    <input wire:model.live="jobTypes" type="checkbox" value="{{ $type }}"
                                        class="checkbox checkbox-sm checkbox-primary" />
                                    <span class="label-text">{{ $type }}</span>
                                    <span class="ml-auto text-xs text-base-content/40">{{ $jobTypeCounts[$type] ?? 0 }}</span>
                                </label>
                            @endif
                        @endforeach
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
                    <input wire:model.live="salaryMin" type="range" min="0" max="100"
                        class="range range-primary range-sm" />
                    <div
                        class="mt-3 text-sm font-medium text-primary text-center bg-primary/5 rounded py-1 border border-primary/10">
                        > LKR {{ number_format($salaryMin * 1200) }} / mo
                    </div>
                </div>
            </div>

            <!-- Industry / Category -->
            <div class="collapse collapse-arrow">
                <input type="checkbox" checked />
                <div class="collapse-title text-sm font-bold">Category</div>
                <div class="collapse-content">
                    <div class="space-y-3">
                        @forelse($availableCategories as $categoryName => $count)
                            <label class="label cursor-pointer justify-start gap-3 py-1">
                                <input wire:model.live="industries" type="checkbox" value="{{ $categoryName }}"
                                    class="checkbox checkbox-sm checkbox-primary" />
                                <span class="label-text">{{ $categoryName }}</span>
                                <span class="ml-auto text-xs text-base-content/40">{{ $count }}</span>
                            </label>
                        @empty
                            <p class="text-xs text-base-content/50">No categories available</p>
                        @endforelse
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
                <input wire:model.live="search" type="text" class="grow"
                    placeholder="Search by job title, company, or keywords..." />
            </label>
        </div>

        <!-- Job Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            @forelse($jobs as $job)
                <div wire:key="job-{{ $job['id'] }}"
                    class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img src="{{ $job['logo'] }}" alt="{{ $job['company'] }} Logo"
                                        class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold hover:text-primary transition-colors">{{ $job['title'] }}
                                    </h3>
                                    <p class="text-sm font-medium text-base-content/70">{{ $job['company'] }} •
                                        {{ $job['industry'] }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click.stop="toggleSaveJob({{ $job['id'] }})" 
                            class="{{ in_array($job['id'], $savedJobIds) ? 'text-error' : 'text-base-content/30 hover:text-error' }} transition-colors"
                            title="{{ in_array($job['id'], $savedJobIds) ? 'Remove from saved' : 'Save job' }}">
                            <x-icon name="{{ in_array($job['id'], $savedJobIds) ? 's-heart' : 'o-heart' }}" class="w-5 h-5" />
                        </button>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="badge badge-primary badge-sm">{{ $job['type'] }}</span>
                            <span class="badge badge-secondary badge-sm">{{ $job['workMode'] }}</span>
                            @if($job['hasApplied'])
                                <span class="badge badge-success badge-sm gap-1">
                                    <x-icon name="o-check-circle" class="w-3 h-3" />
                                    Applied
                                </span>
                            @endif
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
                                <span>Posted
                                    {{ isset($job['postedHours']) ? $job['postedHours'] . ' hours' : $job['postedDays'] . ' days' }}
                                    ago</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="card-actions pt-4 border-t border-base-300">
                            @if($job['hasApplied'])
                                <button disabled
                                    class="btn btn-success btn-outline btn-block btn-sm opacity-60 cursor-not-allowed">
                                    <x-icon name="o-check-circle" class="w-4 h-4" />
                                    Already Applied
                                </button>
                            @else
                                <button wire:click="showJobDetails({{ $job['id'] }})"
                                    class="btn btn-primary btn-outline btn-block btn-sm">
                                    Apply Now
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div
                        class="max-w-md mx-auto flex flex-col items-center p-8 bg-base-100 rounded-xl border border-base-300 shadow-sm text-center">
                        <div class="w-48 h-32 mb-6 bg-primary/10 rounded-full flex items-center justify-center">
                            <x-icon name="o-magnifying-glass-minus" class="text-primary/40 w-16 h-16" />
                        </div>
                        <h3 class="text-lg font-bold mb-2">No jobs found</h3>
                        <p class="text-base-content/70 text-sm mb-6">
                            We couldn't find any jobs matching your current filters. Try adjusting your search keywords or
                            clearing some filters.
                        </p>
                        <button wire:click="clearFilters" class="btn btn-primary btn-sm">
                            Clear All Filters
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Load More -->
        @if($hasMoreJobs)
            <div class="flex flex-col items-center gap-2">
                <button wire:click="loadMore" wire:loading.attr="disabled" class="btn btn-outline gap-2">
                    <span wire:loading.remove wire:target="loadMore">Load More Jobs</span>
                    <span wire:loading wire:target="loadMore">Loading...</span>
                    <x-icon name="o-arrow-down" class="w-4 h-4" wire:loading.remove wire:target="loadMore" />
                    <span wire:loading wire:target="loadMore" class="loading loading-spinner loading-sm"></span>
                </button>
                <span class="text-sm text-base-content/50">Showing {{ $jobCount }} of {{ $totalJobs }} jobs</span>
            </div>
        @endif
    </div>

    <livewire:jobs.detail-modal />
</div>