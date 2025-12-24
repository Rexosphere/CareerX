<?php

use Livewire\Volt\Component;
use App\Models\JobPosting;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    public int $jobId;

    public function with(): array
    {
        $job = JobPosting::with(['applications.student.studentProfile'])->findOrFail($this->jobId);

        return [
            'job' => $job,
            'applications' => $job->applications()->latest()->get()
        ];
    }

    public function downloadCv(int $applicationId)
    {
        $application = Application::findOrFail($applicationId);

        if (!$application->cv_path) {
            $this->dispatch('toast', type: 'error', message: 'No CV uploaded for this application.', title: 'Error');
            return;
        }

        // Check if file exists
        if (!Storage::exists($application->cv_path)) {
            $this->dispatch('toast', type: 'error', message: 'CV file not found on server.', title: 'Error');
            return;
        }

        return Storage::download($application->cv_path);
    }

    public function updateStatus(int $applicationId, string $status)
    {
        $application = Application::findOrFail($applicationId);
        $application->update(['status' => $status]);

        $this->dispatch('toast', type: 'success', message: "Application marked as $status.", title: 'Status Updated');
    }
}; ?>

<div class="space-y-6">
    @forelse($applications as $application)
        @php
            $student = $application->student;
            $profile = $student->studentProfile;
        @endphp
        <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden group">
            <div class="card-body p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6 justify-between">
                    {{-- Student Info --}}
                    <div class="flex gap-6">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-2xl w-24 h-24 text-2xl font-black">
                                <span>{{ $student->initials() }}</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-2xl font-bold text-base-content">{{ $student->name }}</h3>
                            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm text-base-content/60 font-medium">
                                <div class="flex items-center gap-1.5">
                                    <x-icon name="o-envelope" class="w-4 h-4" />
                                    {{ $student->email }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <x-icon name="o-academic-cap" class="w-4 h-4" />
                                    {{ $profile->course ?? 'Not Specified' }}
                                </div>
                                <div class="flex items-center gap-1.5 text-primary bg-primary/10 px-2 py-0.5 rounded-md">
                                    <x-icon name="o-briefcase" class="w-4 h-4" />
                                    {{ $application->status }}
                                </div>
                            </div>

                            <p class="text-base-content/70 mt-4 line-clamp-2 max-w-2xl text-lg italic">
                                "{{ $application->cover_letter ?? 'No cover letter provided.' }}"
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-row md:flex-col gap-3 justify-center items-stretch md:w-56 shrink-0">
                        @if($application->cv_path)
                            <button wire:click="downloadCv({{ $application->id }})"
                                class="btn btn-primary shadow-lg shadow-primary/20">
                                <x-icon name="o-arrow-down-tray" class="w-4 h-4" />
                                Download CV
                            </button>
                        @else
                            <button class="btn btn-disabled" disabled>
                                No CV Provided
                            </button>
                        @endif

                        <div class="dropdown dropdown-end w-full">
                            <div tabindex="0" role="button" class="btn btn-outline border-base-300 w-full">Update Status
                            </div>
                            <ul tabindex="0"
                                class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 border border-base-300">
                                <li><a wire:click="updateStatus({{ $application->id }}, 'reviewed')">Mark as Reviewed</a>
                                </li>
                                <li><a wire:click="updateStatus({{ $application->id }}, 'shortlisted')"
                                        class="text-success font-bold">Shortlist</a></li>
                                <li><a wire:click="updateStatus({{ $application->id }}, 'rejected')"
                                        class="text-error font-bold">Reject</a></li>
                                <li><a wire:click="updateStatus({{ $application->id }}, 'accepted')"
                                        class="text-primary font-bold">Accept</a></li>
                            </ul>
                        </div>

                        <a href="{{ route('students.profile', $student->id) }}"
                            class="btn btn-ghost btn-sm text-primary hover:bg-primary/5">
                            View Full Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card bg-base-100 shadow-xl border border-base-200 border-dashed py-24 text-center">
            <div
                class="w-20 h-20 bg-base-200 rounded-full flex items-center justify-center mx-auto mb-6 text-base-content/20">
                <x-icon name="o-user-group" class="w-12 h-12" />
            </div>
            <h3 class="text-2xl font-bold mb-2">No applications yet</h3>
            <p class="text-base-content/60 mb-8 max-w-sm mx-auto">Wait for students to discover your job listing and apply.
            </p>
        </div>
    @endforelse
</div>