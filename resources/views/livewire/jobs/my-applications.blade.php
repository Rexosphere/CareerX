<?php
use Livewire\Volt\Component;

new class extends Component {
    public array $applications = [];
    public string $statusFilter = 'all';
    public string $sortBy = 'newest';

    public function mount(): void
    {
        $this->loadApplications();
    }

    public function loadApplications(): void
    {
        if (!auth('web')->check() || !auth('web')->user()->isStudent()) {
            $this->applications = [];
            return;
        }

        $query = auth('web')->user()->applications()->with('jobPosting');

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $this->applications = $query->get()
            ->map(function ($application) {
                $job = $application->jobPosting;
                
                if (!$job) {
                    return null;
                }

                // Get company logo
                $logo = null;
                if ($job->company && $job->company->logo_path) {
                    $logo = asset('storage/' . $job->company->logo_path);
                } elseif ($job->company_logo) {
                    $logo = $job->company_logo;
                } else {
                    $logo = 'https://ui-avatars.com/api/?name=' . urlencode($job->company_name);
                }

                return [
                    'id' => $application->id,
                    'job_id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company_name,
                    'location' => $job->location,
                    'type' => $job->type,
                    'logo' => $logo,
                    'status' => $application->status,
                    'applied_at' => $application->created_at->format('M d, Y'),
                    'applied_days_ago' => (int) $application->created_at->diffInDays(),
                    'cover_letter' => $application->cover_letter,
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }

    public function updated($property): void
    {
        if (in_array($property, ['statusFilter', 'sortBy'])) {
            $this->loadApplications();
        }
    }

    public function getStatusBadgeClass(string $status): string
    {
        return match($status) {
            'pending' => 'badge-warning',
            'reviewing' => 'badge-info',
            'shortlisted' => 'badge-primary',
            'rejected' => 'badge-error',
            'accepted' => 'badge-success',
            default => 'badge-ghost',
        };
    }

    public function getStatusCount(string $status): int
    {
        if (!auth('web')->check() || !auth('web')->user()->isStudent()) {
            return 0;
        }

        if ($status === 'all') {
            return auth('web')->user()->applications()->count();
        }

        return auth('web')->user()->applications()->where('status', $status)->count();
    }
}; ?>

<div>
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="stats shadow border border-base-300 {{ $statusFilter === 'all' ? 'ring-2 ring-primary' : '' }}">
            <div class="stat p-4 cursor-pointer" wire:click="$set('statusFilter', 'all')">
                <div class="stat-title text-xs">Total</div>
                <div class="stat-value text-2xl">{{ $this->getStatusCount('all') }}</div>
            </div>
        </div>
        <div class="stats shadow border border-base-300 {{ $statusFilter === 'pending' ? 'ring-2 ring-warning' : '' }}">
            <div class="stat p-4 cursor-pointer" wire:click="$set('statusFilter', 'pending')">
                <div class="stat-title text-xs">Pending</div>
                <div class="stat-value text-2xl text-warning">{{ $this->getStatusCount('pending') }}</div>
            </div>
        </div>
        <div class="stats shadow border border-base-300 {{ $statusFilter === 'reviewing' ? 'ring-2 ring-info' : '' }}">
            <div class="stat p-4 cursor-pointer" wire:click="$set('statusFilter', 'reviewing')">
                <div class="stat-title text-xs">Reviewing</div>
                <div class="stat-value text-2xl text-info">{{ $this->getStatusCount('reviewing') }}</div>
            </div>
        </div>
        <div class="stats shadow border border-base-300 {{ $statusFilter === 'shortlisted' ? 'ring-2 ring-primary' : '' }}">
            <div class="stat p-4 cursor-pointer" wire:click="$set('statusFilter', 'shortlisted')">
                <div class="stat-title text-xs">Shortlisted</div>
                <div class="stat-value text-2xl text-primary">{{ $this->getStatusCount('shortlisted') }}</div>
            </div>
        </div>
        <div class="stats shadow border border-base-300 {{ $statusFilter === 'accepted' ? 'ring-2 ring-success' : '' }}">
            <div class="stat p-4 cursor-pointer" wire:click="$set('statusFilter', 'accepted')">
                <div class="stat-title text-xs">Accepted</div>
                <div class="stat-value text-2xl text-success">{{ $this->getStatusCount('accepted') }}</div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2">
            <span class="text-sm text-base-content/70 font-medium">
                Showing {{ count($applications) }} application(s)
            </span>
            @if($statusFilter !== 'all')
                <button wire:click="$set('statusFilter', 'all')" class="btn btn-ghost btn-xs gap-1">
                    <x-icon name="o-x-mark" class="w-3 h-3" />
                    Clear filter
                </button>
            @endif
        </div>
        <select wire:model.live="sortBy" class="select select-bordered select-sm">
            <option value="newest">Sort: Newest First</option>
            <option value="oldest">Sort: Oldest First</option>
        </select>
    </div>

    <!-- Applications List -->
    <div class="space-y-4">
        @forelse($applications as $app)
            <div wire:key="application-{{ $app['id'] }}"
                class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="card-body p-5">
                    <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                        <!-- Left: Job Info -->
                        <div class="flex gap-4 flex-1">
                            <div class="w-12 h-12 rounded-lg bg-base-200 border border-base-300 flex items-center justify-center overflow-hidden flex-shrink-0">
                                <img src="{{ $app['logo'] }}" alt="{{ $app['company'] }} Logo"
                                    class="w-full h-full object-cover" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold mb-1">{{ $app['title'] }}</h3>
                                <p class="text-sm font-medium text-base-content/70 mb-3">
                                    {{ $app['company'] }}
                                </p>
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="badge badge-sm">{{ $app['type'] }}</span>
                                    <span class="badge badge-sm badge-ghost">
                                        <x-icon name="o-map-pin" class="w-3 h-3 mr-1" />
                                        {{ $app['location'] }}
                                    </span>
                                    <span class="badge badge-sm {{ $this->getStatusBadgeClass($app['status']) }}">
                                        {{ ucfirst($app['status']) }}
                                    </span>
                                </div>
                                <p class="text-xs text-base-content/60">
                                    <x-icon name="o-clock" class="w-3 h-3 inline" />
                                    Applied {{ $app['applied_days_ago'] }} days ago ({{ $app['applied_at'] }})
                                </p>
                            </div>
                        </div>

                        <!-- Right: Actions -->
                        <div class="flex flex-col gap-2 lg:items-end">
                            <a href="{{ route('jobs.index') }}" 
                                class="btn btn-outline btn-sm gap-2">
                                <x-icon name="o-eye" class="w-4 h-4" />
                                View Job
                            </a>
                            @if($app['cover_letter'])
                                <button class="btn btn-ghost btn-sm gap-2"
                                    onclick="document.getElementById('cover-letter-{{ $app['id'] }}').showModal()">
                                    <x-icon name="o-document-text" class="w-4 h-4" />
                                    View Cover Letter
                                </button>

                                <!-- Cover Letter Modal -->
                                <dialog id="cover-letter-{{ $app['id'] }}" class="modal">
                                    <div class="modal-box max-w-2xl">
                                        <h3 class="font-bold text-lg mb-4">Cover Letter</h3>
                                        <div class="prose max-w-none">
                                            <p class="whitespace-pre-wrap">{{ $app['cover_letter'] }}</p>
                                        </div>
                                        <div class="modal-action">
                                            <form method="dialog">
                                                <button class="btn">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                    <form method="dialog" class="modal-backdrop">
                                        <button>close</button>
                                    </form>
                                </dialog>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="max-w-md mx-auto flex flex-col items-center p-8 bg-base-100 rounded-xl border border-base-300 shadow-sm text-center">
                <div class="w-48 h-32 mb-6 bg-primary/10 rounded-full flex items-center justify-center">
                    <x-icon name="o-briefcase" class="text-primary/40 w-16 h-16" />
                </div>
                <h3 class="text-lg font-bold mb-2">
                    @if($statusFilter === 'all')
                        No applications yet
                    @else
                        No {{ $statusFilter }} applications
                    @endif
                </h3>
                <p class="text-base-content/70 text-sm mb-6">
                    @if($statusFilter === 'all')
                        Start applying to jobs to see them here.
                    @else
                        You don't have any applications with this status.
                    @endif
                </p>
                <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm">
                    Browse Jobs
                </a>
            </div>
        @endforelse
    </div>
</div>
