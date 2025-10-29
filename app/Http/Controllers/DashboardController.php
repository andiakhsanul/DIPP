<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Redirect admin to admin dashboard
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Get user registrations with batch details
        $registrations = $user->registrations()
            ->with('batch')
            ->latest()
            ->get();

        return view('dashboard', compact('registrations'));
    }
}
