<?php

namespace App\Livewire\Company;

use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithPagination;

class JobApplicationsListing extends Component
{
    use WithPagination;

    public $jobId;

    public function mount($jobId)
    {
        $this->jobId = $jobId;
    }

    public function render()
    {
        $job = JobPosting::with(['applications.student'])->findOrFail($this->jobId);

        // Ensure company owns this job
        if ($job->company_id != auth('company')->id()) {
            abort(403);
        }

        $applications = $job->applications()->latest()->paginate(10);

        return view('livewire.company.job-applications-listing', [
            'job' => $job,
            'applications' => $applications
        ]);
    }
}
