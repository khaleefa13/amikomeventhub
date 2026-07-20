<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan Halaman Login
    public function showLogin()
    {
        // Jika sudah dalam keadaan login, langsung arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    // Memproses Data Login
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 🌟 PERBAIKAN: Menggunakan route name, bukan URL statis '/admin'
            return redirect()->route('admin.dashboard'); 
        }

        // Jika email/password salah, kembalikan dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Kembalikan ke halaman login setelah keluar
        return redirect('/login');
    }
    
    // FUNGSI MENAMPILKAN FORM PENDAFTARAN HIMA
    public function showRegisterHima()
    {
        return view('auth.register_hima');
    }

    // FUNGSI MEMPROSES DATA PENDAFTARAN
    public function processRegisterHima(Request $request)
    {
        // Validasi inputan form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Email ini sudah terdaftar!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'password.min' => 'Password minimal 6 karakter!'
        ]);

        // Buat akun ke database dengan status 'pending'
        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'organizer',
            'approval_status' => 'pending', 
        ]);

        // Arahkan kembali ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda sedang direview. Silakan tunggu persetujuan dari Superadmin untuk bisa Login.');
    }
}