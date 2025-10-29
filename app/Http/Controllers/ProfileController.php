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
            'nidn_nidk_nuptk' => 'required|string|max:50',
            'institution' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        UserProfile::create([
            'user_id' => auth()->id(),
            ...$validated
        ]);

        return redirect()->route('registration.create')
            ->with('success', 'Profile completed! Please proceed with training registration.');
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
            'nidn_nidk_nuptk' => 'required|string|max:50',
            'institution' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        $profile->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Profile updated successfully!');
    }
}
