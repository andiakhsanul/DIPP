<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_registrations' => Registration::count(),
            'pending_registrations' => Registration::pending()->count(),
            'approved_registrations' => Registration::approved()->count(),
            'total_batches' => Batch::count(),
            'active_batches' => Batch::where('is_active', true)->count(),
        ];

        $recent_registrations = Registration::with(['user.profile', 'batch'])
            ->latest()
            ->take(10)
            ->get();

        $active_batches = Batch::where('is_active', true)
            ->withCount('registrations')
            ->orderBy('start_date')
            ->take(5)
            ->get();

        $all_batches = Batch::withCount('registrations')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_registrations', 'active_batches', 'all_batches'));
    }
}
