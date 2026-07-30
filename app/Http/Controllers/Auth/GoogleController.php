<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect ke halaman login Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Callback setelah login Google berhasil.
     */
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {

            // Jika belum ada, buat user baru
            $user = User::create([
                'name'       => $googleUser->getName(),
                'email'      => $googleUser->getEmail(),
                'password'   => Hash::make(Str::random(24)),
                'role'       => 'user',
                'google_id'  => $googleUser->getId(),
                'avatar'     => $googleUser->getAvatar(),
            ]);

        } else {

            // Update data Google jika user sudah ada
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

        }

        // Login user
        Auth::login($user, true);

        return redirect()
            ->route('home')
            ->with('success', 'Berhasil login menggunakan Google.');
    }
}