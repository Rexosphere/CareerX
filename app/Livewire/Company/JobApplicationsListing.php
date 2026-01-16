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

    public function updateApplicationStatus($applicationId, $newStatus)
    {
        // Validate status
        $validStatuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'accepted'];
        if (!in_array($newStatus, $validStatuses)) {
            session()->flash('error', 'Invalid status provided.');
            return;
        }

        $application = \App\Models\Application::findOrFail($applicationId);
        
        // Ensure this application belongs to a job owned by this company
        if ($application->jobPosting->company_id != auth('company')->id()) {
            abort(403);
        }

        $oldStatus = $application->status;
        
        // Update status
        $application->update(['status' => $newStatus]);
        
        // Send notification to student if status changed
        if ($oldStatus !== $newStatus) {
            $application->student->notify(new \App\Notifications\ApplicationStatusChanged(
                $application,
                $oldStatus,
                $newStatus
            ));
        }
        
        session()->flash('message', 'Application status updated successfully.');
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
