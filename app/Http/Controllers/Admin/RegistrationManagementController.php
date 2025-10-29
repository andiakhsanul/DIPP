<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationManagementController extends Controller
{
    /**
     * Show all registrations
     */
    public function index(Request $request)
    {
        $query = Registration::with(['user.profile', 'batch']);

        // Filter by status if requested
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by batch if requested
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        $registrations = $query->latest()->get();

        return view('admin.registrations.index', compact('registrations'));
    }

    /**
     * Show registration details
     */
    public function show(Registration $registration)
    {
        $registration->load(['user.profile', 'batch']);
        
        return view('admin.registrations.show', compact('registration'));
    }

    /**
     * Approve registration
     */
    public function approve(Registration $registration)
    {
        $batch = $registration->batch;

        // Check if batch is full
        if ($batch->isFull()) {
            return back()->with('error', 'Cannot approve: Batch is full.');
        }

        $registration->approve();

        return back()->with('success', 'Registration approved successfully!');
    }

    /**
     * Reject registration
     */
    public function reject(Registration $registration)
    {
        $registration->reject();

        return back()->with('success', 'Registration rejected.');
    }
}
