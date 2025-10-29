<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of batches
     */
    public function index()
    {
        $batches = Batch::withCount('registrations')
            ->latest()
            ->get();

        return view('admin.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new batch
     */
    public function create()
    {
        return view('admin.batches.create');
    }

    /**
     * Store a newly created batch
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_name' => 'required|string|max:255',
            'training_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'quota' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start|before:start_date',
        ]);

        Batch::create($validated);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch berhasil dibuat!');
    }

    /**
     * Display the specified batch
     */
    public function show(Batch $batch)
    {
        $batch->load(['registrations.user.profile']);
        
        return view('admin.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified batch
     */
    public function edit(Batch $batch)
    {
        $batch->loadCount('registrations');
        
        return view('admin.batches.edit', compact('batch'));
    }

    /**
     * Update the specified batch
     */
    public function update(Request $request, Batch $batch)
    {
        $approvedCount = $batch->registrations()->approved()->count();
        
        $validated = $request->validate([
            'batch_name' => 'required|string|max:255',
            'training_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'quota' => 'required|integer|min:' . $approvedCount,
            'max_participants' => 'required|integer|min:' . $approvedCount,
            'location' => 'nullable|string|max:255',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
        ]);

        $batch->update($validated);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch berhasil diupdate!');
    }

    /**
     * Remove the specified batch
     */
    public function destroy(Batch $batch)
    {
        // Delete batch (cascade will delete registrations)
        $batch->delete();

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch berhasil dihapus!');
    }

    /**
     * Toggle batch active status
     */
    public function toggleActive(Batch $batch)
    {
        $batch->update(['is_active' => !$batch->is_active]);

        $status = $batch->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Batch $status successfully!");
    }
}
