<?php

namespace App\Livewire\Company;

use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public function deleteJob($jobId)
    {
        $job = JobPosting::where('company_id', Auth::guard('company')->id())
            ->findOrFail($jobId);

        $job->delete();
        session()->flash('message', "Job posting '{$job->title}' has been deleted.");
    }

    public function render()
    {
        $companyId = Auth::guard('company')->id();

        $jobs = JobPosting::where('company_id', $companyId)
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_jobs' => JobPosting::where('company_id', $companyId)->count(),
            'active_jobs' => JobPosting::where('company_id', $companyId)->where('is_active', true)->count(),
            'total_applications' => JobPosting::where('company_id', $companyId)->withCount('applications')->get()->sum('applications_count'),
        ];

        return view('livewire.company.dashboard', [
            'jobs' => $jobs,
            'stats' => $stats
        ])->title('Company Dashboard');
    }
}
