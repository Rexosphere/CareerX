<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\JobPosting;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $stats = [];
    public string $activeTab = 'companies'; // 'companies' or 'jobs'

    public function mount()
    {
        $this->refreshStats();
    }

    public function refreshStats()
    {
        $this->stats = [
            'total_users' => User::count(),
            'total_companies' => Company::count(),
            'total_jobs' => JobPosting::count(),
            'pending_companies' => Company::where('status', 'pending')->count(),
        ];
    }

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function approve($companyId)
    {
        $company = Company::findOrFail($companyId);
        $company->update(['status' => 'active']);
        session()->flash('message', "Company {$company->name} has been approved.");
        $this->refreshStats();
    }

    public function reject($companyId)
    {
        $company = Company::findOrFail($companyId);
        $company->update(['status' => 'rejected']);
        session()->flash('message', "Company {$company->name} has been rejected.");
        $this->refreshStats();
    }

    public function deleteJob($jobId)
    {
        $job = JobPosting::findOrFail($jobId);
        $job->delete();
        session()->flash('message', "Job posting '{$job->title}' has been deleted.");
        $this->refreshStats();
    }

    public function render()
    {
        $pendingCompanies = Company::where('status', 'pending')
            ->latest()
            ->paginate(10);

        $jobs = JobPosting::with('company')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.dashboard', [
            'pendingCompanies' => $pendingCompanies,
            'jobs' => $jobs
        ]);
    }
}
