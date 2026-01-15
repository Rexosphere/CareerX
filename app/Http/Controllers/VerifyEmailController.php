<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        // Find the user by ID from the URL
        $user = User::findOrFail($request->route('id'));

        // Verify the hash matches
        if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
            abort(403, 'Invalid verification link.');
        }

        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            // If user is authenticated, redirect to onboarding
            if (Auth::check() && Auth::id() === $user->id) {
                return redirect()->route('onboarding')->with('message', 'Email already verified!');
            }
            
            // For guest users, show success page
            return view('pages.auth.email-verified-success', [
                'alreadyVerified' => true,
                'email' => $user->email
            ]);
        }

        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // If the user is authenticated and it's their own verification
        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->route('onboarding')->with('message', 'Email verified successfully!');
        }

        // For guest users (different browser/device), show success page
        return view('pages.auth.email-verified-success', [
            'alreadyVerified' => false,
            'email' => $user->email
        ]);
    }
}
