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
        $employer = User::find($jobPosting->employer_id);

        if (!$employer) {
            throw new \Exception('Employer not found.');
        }

        if (!$employer->isEmployer()) {
            throw new \Exception('Only users with the employer role can create job postings.');
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
