<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->hasCompletedProfile()) {
            return redirect()->route('profile.create')
                ->with('warning', 'Please complete your profile first.');
        }

        return $next($request);
    }
}
