<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationAlert;
use Illuminate\Http\Request;

class RegistrationAlertController extends Controller
{
    /**
     * Display a listing of registration alerts.
     */
    public function index()
    {
        $alerts = RegistrationAlert::latest()->paginate(10);
        return view('admin.registration-alerts.index', compact('alerts'));
    }

    /**
     * Show the form for creating a new alert.
     */
    public function create()
    {
        return view('admin.registration-alerts.create');
    }

    /**
     * Store a newly created alert in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'alert_type' => 'required|in:info,warning,error,success',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        RegistrationAlert::create($validated);

        return redirect()->route('admin.registration-alerts.index')
            ->with('success', 'Alert registrasi berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified alert.
     */
    public function edit(RegistrationAlert $registration_alert)
    {
        return view('admin.registration-alerts.edit', ['alert' => $registration_alert]);
    }

    /**
     * Update the specified alert in storage.
     */
    public function update(Request $request, RegistrationAlert $registration_alert)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'alert_type' => 'required|in:info,warning,error,success',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $registration_alert->update($validated);

        return redirect()->route('admin.registration-alerts.index')
            ->with('success', 'Alert registrasi berhasil diperbarui.');
    }

    /**
     * Remove the specified alert from storage.
     */
    public function destroy(RegistrationAlert $registration_alert)
    {
        $registration_alert->delete();

        return redirect()->route('admin.registration-alerts.index')
            ->with('success', 'Alert registrasi berhasil dihapus.');
    }

    /**
     * Toggle the active status of the specified alert.
     */
    public function toggleStatus(RegistrationAlert $registration_alert)
    {
        $registration_alert->update([
            'is_active' => !$registration_alert->is_active
        ]);

        $status = $registration_alert->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.registration-alerts.index')
            ->with('success', "Alert registrasi berhasil {$status}.");
    }
}
