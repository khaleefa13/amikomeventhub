<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        // Mencatat halaman tempat user menekan tombol Google
        session(['alamat_kembali' => url()->previous()]);
        
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Menerima data dari Google secara aman (Tanpa Bypass)
            $googleUser = Socialite::driver('google')->user();
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                if (empty($existingUser->google_id)) {
                    $existingUser->update(['google_id' => $googleUser->getId()]);
                }
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'user', 
                ]);
                Auth::login($newUser);
            }

            // Memulangkan user ke halaman checkout
            $urlTujuan = session('alamat_kembali', '/');
            session()->forget('alamat_kembali');

            return redirect($urlTujuan);

        } catch (\Exception $e) {
            // Jika gagal, kembalikan ke beranda dengan pesan error
            return redirect('/')->with('error', 'Gagal login menggunakan Google. Silakan coba lagi.');
        }
    }
}