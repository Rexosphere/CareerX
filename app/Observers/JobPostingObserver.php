<?php

namespace App\Observers;

use App\Models\JobPosting;
use App\Models\User;

class JobPostingObserver
{
    /**
     * Handle the JobPosting "creating" event.
     * Validate that the employer has the correct role before creation.
     */
    public function creating(JobPosting $jobPosting): bool
    {
        $company = \App\Models\Company::find($jobPosting->company_id);

        if (!$company) {
            throw new \Exception('Company not found.');
        }

        if ($company->status !== 'active') {
            throw new \Exception('Your company account is not active. Please contact administration.');
        }

        return true;
    }

    /**
     * Handle the JobPosting "created" event.
     */
    public function created(JobPosting $jobPosting): void
    {
        //
    }

    /**
     * Handle the JobPosting "updated" event.
     */
    public function updated(JobPosting $jobPosting): void
    {
        //
    }

    /**
     * Handle the JobPosting "deleted" event.
     */
    public function deleted(JobPosting $jobPosting): void
    {
        //
    }

    /**
     * Handle the JobPosting "restored" event.
     */
    public function restored(JobPosting $jobPosting): void
    {
        //
    }

    /**
     * Handle the JobPosting "force deleted" event.
     */
    public function forceDeleted(JobPosting $jobPosting): void
    {
        //
    }
}
