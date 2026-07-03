<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find existing user by google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                // User exists with this google_id, log them in
                Auth::login($user);
            } else {
                // Check if user exists with the same email
                $existingUser = User::where('email', $googleUser->getEmail())->first();

                if ($existingUser) {
                    // Update existing user to include google_id
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                    Auth::login($existingUser);
                } else {
                    // Reject unregistered users
                    return redirect()->route('login')->with('error', 'Akun Gmail Anda belum terdaftar. Silakan hubungi administrator.');
                }
            }

            return redirect()->intended(route('home', absolute: false));
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google. Silakan coba lagi.');
        }
    }
}
