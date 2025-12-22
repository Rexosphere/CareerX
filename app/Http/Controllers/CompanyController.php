<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;

class CompanyController extends Controller
{
    /**
     * Display the company profile and job listings.
     */
    public function profile()
    {
        $company = auth('company')->user();

        if (!$company) {
            abort(403, 'Unauthorized action.');
        }

        $jobs = $company->jobPostings()->orderBy('created_at', 'desc')->get();

        return view('pages.company.profile', [
            'user' => $company, // Keep variable name as 'user' for compatibility with existing view if needed
            'jobs' => $jobs
        ]);
    }
}
