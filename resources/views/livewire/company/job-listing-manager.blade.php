<?php

use Livewire\Volt\Component;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public function delete(int $id)
    {
        $job = JobPosting::findOrFail($id);
        
        // Ensure the company owns the job
        if ($job->company_id !== Auth::guard('company')->id()) {
            $this->dispatch('toast', type: 'error', message: 'Unauthorized action.', title: 'Error');
            return;
        }

        $job->delete();
        $this->dispatch('toast', type: 'success', message: 'Job posting deleted successfully!', title: 'Deleted');
    }

    public function with(): array
    {
        $company = Auth::guard('company')->user();
        return [
            'jobs' => $company->jobPostings()->orderBy('created_at', 'desc')->get()
        ];
    }
}; ?>

<div class="grid grid-cols-1 gap-6">
    @forelse($jobs as $job)
        <div class="card bg-base-100 shadow-xl border border-base-200 hover:border-primary/30 transition-all group overflow-hidden" wire:key="{{ $job->id }}">
            <div class="card-body p-8">
                <div class="flex flex-col lg:flex-row justify-between gap-8">
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center gap-3">
                            <h3 class="text-2xl font-bold text-base-content group-hover:text-primary transition-colors">
                                {{ $job->title }}
                            </h3>
                            @if($job->is_active ?? true)
                                <div class="badge badge-success badge-sm py-3 px-3 gap-1">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div>
                                    Active
                                </div>
                            @else
                                <div class="badge badge-ghost badge-sm py-3 px-3">Closed</div>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-4 text-sm text-base-content/60">
                            <div class="flex items-center gap-1.5">
                                <x-icon name="o-map-pin" class="w-4 h-4 text-primary" />
                                {{ $job->location ?? 'Remote' }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <x-icon name="o-calendar" class="w-4 h-4 text-primary" />
                                Posted {{ $job->created_at->diffForHumans() }}
                            </div>
                            <div class="flex items-center gap-1.5">
                                <x-icon name="o-banknotes" class="w-4 h-4 text-primary" />
                                {{ $job->salary_range ?? 'Competitive Pay' }}
                            </div>
                        </div>

                        <p class="text-base-content/70 leading-relaxed line-clamp-2 text-lg">
                            {{ Str::limit($job->description, 250) }}
                        </p>

                        <div class="flex gap-2">
                            <div class="badge badge-outline border-base-300 px-4 py-3">
                                {{ $job->type ?? 'Full-time' }}</div>
                            <div class="badge badge-outline border-base-300 px-4 py-3">
                                {{ $job->category ?? 'Software Engineering' }}</div>
                        </div>
                    </div>

                    <div class="flex flex-row lg:flex-col gap-3 justify-center">
                        <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-primary px-8">View Applications</a>
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-outline border-base-300 shadow-sm">
                            <x-icon name="o-pencil" class="w-4 h-4" />
                            Edit Job
                        </a>
                        <button 
                            wire:click="delete({{ $job->id }})" 
                            wire:confirm="Are you sure you want to delete this job posting? This action cannot be undone."
                            class="btn btn-error btn-outline shadow-sm"
                        >
                            <x-icon name="o-trash" class="w-4 h-4" />
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card bg-base-100 shadow-xl border border-base-200 border-dashed py-20 text-center">
            <div class="w-20 h-20 bg-base-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <x-icon name="o-briefcase" class="w-10 h-10 opacity-20" />
            </div>
            <h3 class="text-2xl font-bold mb-2">No jobs posted yet</h3>
            <p class="text-base-content/60 mb-8 max-w-sm mx-auto">Start attracting top talent by creating your
                first job listing today.</p>
            <a href="{{ route('jobs.create') }}" class="btn self-center btn-primary btn-wide shadow-lg shadow-primary/20">
                Create First Listing
            </a>
        </div>
    @endforelse
</div>
