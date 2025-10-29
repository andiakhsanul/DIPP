<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    /**
     * Show registration form
     */
    public function create()
    {
        $batches = Batch::where('status', 'open')
            ->where('registration_end', '>=', now())
            ->withCount('registrations')
            ->get();

        return view('registration.create', compact('batches'));
    }

    /**
     * Store registration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'npwp_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'surat_tugas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if user already registered for this batch
        $existingRegistration = Registration::where('user_id', auth()->id())
            ->where('batch_id', $validated['batch_id'])
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'You have already registered for this batch.');
        }

        DB::beginTransaction();

        try {
            $batch = Batch::findOrFail($validated['batch_id']);

            // Check quota with FIFO logic
            $approvedCount = $batch->approvedCount();
            
            if ($approvedCount >= $batch->quota) {
                DB::rollBack();
                return back()->with('error', 'Sorry, this batch is full. Please choose another batch.');
            }

            // Upload files
            $paymentReceipt = $request->file('payment_receipt')->store('public/payment_receipts');
            $npwpKtp = $request->file('npwp_ktp')->store('public/documents');
            $suratTugas = $request->file('surat_tugas')->store('public/documents');

            // Create registration (status pending by default)
            Registration::create([
                'user_id' => auth()->id(),
                'batch_id' => $validated['batch_id'],
                'registration_date' => now(),
                'status' => 'pending',
                'payment_receipt_url' => Storage::url($paymentReceipt),
                'npwp_ktp' => Storage::url($npwpKtp),
                'surat_tugas' => Storage::url($suratTugas),
            ]);

            DB::commit();

            return redirect()->route('dashboard')
                ->with('success', 'Registration submitted successfully! Please wait for admin approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Show user's registrations
     */
    public function index()
    {
        $registrations = auth()->user()
            ->registrations()
            ->with('batch')
            ->latest()
            ->paginate(10);

        return view('registration.index', compact('registrations'));
    }
}
