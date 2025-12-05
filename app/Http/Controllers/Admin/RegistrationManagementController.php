<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Get registration detail for AJAX
     */
    public function detail(Registration $registration)
    {
        $registration->load(['user.profile', 'batch']);
        
        // Helper function to get proper URL
        $getFileUrl = function($path) {
            if (!$path) return null;
            // If path already starts with /storage/, use it as is (old format)
            if (str_starts_with($path, '/storage/')) {
                return url($path);
            }
            // If path already starts with storage/, use it as is
            if (str_starts_with($path, 'storage/')) {
                return url($path);
            }
            // Otherwise, use Storage::url() (new format)
            return Storage::url($path);
        };
        
        return response()->json([
            'id' => $registration->id,
            'status' => $registration->status,
            'created_at' => $registration->created_at->format('d M Y H:i'),
            'updated_at' => $registration->updated_at->format('d M Y H:i'),
            'payment_receipt' => $getFileUrl($registration->payment_receipt_url),
            'npwp_ktp' => $getFileUrl($registration->npwp_ktp),
            'surat_tugas' => $getFileUrl($registration->surat_tugas),
            'pekerti_certificate' => $getFileUrl($registration->pekerti_certificate),
            'user' => [
                'name' => $registration->user->name,
                'email' => $registration->user->email,
                'profile' => [
                    'full_name' => $registration->user->profile->full_name ?? '-',
                    'nidn' => $registration->user->profile->nidn ?? '-',
                    'university' => $registration->user->profile->university ?? '-',
                    'phone_number' => $registration->user->profile->phone_number ?? '-',
                ],
            ],
            'batch' => [
                'batch_name' => $registration->batch->batch_name,
                'name' => $registration->batch->batch_name, // For backward compatibility
                'training_type' => $registration->batch->training_type,
                'start_date' => $registration->batch->start_date->format('d M Y'),
                'end_date' => $registration->batch->end_date->format('d M Y'),
                'location' => $registration->batch->location ?? '-',
                'max_participants' => $registration->batch->max_participants,
                'quota' => $registration->batch->quota,
            ],
        ]);
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
