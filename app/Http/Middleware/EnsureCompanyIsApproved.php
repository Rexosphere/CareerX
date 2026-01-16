<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = auth('company')->user();

        if ($company && $company->status !== 'active') {
            // Redirect unapproved companies to pending page
            return redirect()->route('company.pending');
        }

        return $next($request);
    }
}
