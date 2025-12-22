<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the applicants (students).
     */
    public function index()
    {
        // Fetch all users with 'student' type or role
        // Assuming 'isStudent' check relies on 'user_type' being 'student' or role relation.
        // We can just query by user_type if it is consistent, or whereHas roles.
        // Based on User model, isStudent check uses role. Let's assume standard query.

        // We will filter by user_type column for efficiency as per migration
        $applicants = User::where('user_type', 'student')
            ->with('studentProfile')
            ->paginate(12);

        return view('pages.applicants.index', [
            'applicants' => $applicants
        ]);
    }
}
