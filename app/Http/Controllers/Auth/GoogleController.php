<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

/**
 * Google OAuth Controller
 *
 * Handles Google OAuth authentication flow.
 * Users who login via Google are automatically verified
 * and don't need email verification.
 */
class GoogleController extends Controller
{
    /**
     * Redirect to Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Handle Google callback after authentication.
     *
     * Creates new user or updates existing user with Google credentials.
     * Auto-verifies email for Google users and redirects to dashboard
     * or profile creation page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update existing user with Google credentials
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(), // Auto-verify Google users
                    'password' => null, // No password for Google users
                ]);
            }

            Auth::login($user);

            // Check if profile is completed
            if (!$user->hasCompletedProfile()) {
                return redirect()->route('profile.create')
                    ->with('info', 'Please complete your profile to continue.');
            }

            return redirect()->route('dashboard');

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Failed to login with Google. Please try again.');
        }
    }
}
