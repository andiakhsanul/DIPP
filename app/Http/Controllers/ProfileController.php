<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show profile creation form
     */
    public function create()
    {
        // Redirect if profile already exists
        if (auth()->user()->hasCompletedProfile()) {
            return redirect()->route('dashboard');
        }

        return view('profile.create');
    }

    /**
     * Store user profile
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nidn' => 'required|string|size:10|unique:user_profiles,nidn',
            'university' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:13',
        ]);

        UserProfile::create([
            'user_id' => auth()->id(),
            'full_name' => $validated['full_name'],
            'nidn' => $validated['nidn'],
            'university' => $validated['university'],
            'phone_number' => $validated['phone_number'],
        ]);

        return redirect()->route('registration.create')
            ->with('success', 'Profil berhasil dilengkapi! Silakan lanjutkan ke pendaftaran pelatihan.');
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        $profile = auth()->user()->profile;

        if (!$profile) {
            return redirect()->route('profile.create');
        }

        return view('profile.edit', compact('profile'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $profile = auth()->user()->profile;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nidn' => 'required|string|size:10|unique:user_profiles,nidn,' . $profile->user_id . ',user_id',
            'university' => 'required|string|max:255',
            'phone_number' => 'required|string|min:10|max:13',
        ]);

        $profile->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
