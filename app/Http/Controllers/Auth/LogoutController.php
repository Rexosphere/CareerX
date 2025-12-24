<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 1. Logout from all configured guards to ensure every possible session is cleared
        $guards = array_keys(config('auth.guards', ['web' => [], 'admin' => [], 'company' => []]));

        foreach ($guards as $guard) {
            Auth::guard($guard)->logout();
        }

        // 2. Wipe the session and regenerate the security token
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Redirect to the home page with headers that prevent the browser from caching the previous "logged in" state
        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }
}
