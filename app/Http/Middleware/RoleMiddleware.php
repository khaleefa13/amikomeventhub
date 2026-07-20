<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    // Menggunakan ...$roles agar bisa menerima banyak role sekaligus
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah role user ada di dalam daftar role yang diizinkan router
            if (in_array($user->role, $roles)) {
                
                // JIKA DIA ORGANIZER, CEK STATUS APPROVAL-NYA!
                if ($user->role === 'organizer' && $user->approval_status === 'pending') {
                    Auth::logout();
                    return redirect('/login')->with('error', 'Akun Organizer Anda sedang menunggu persetujuan Superadmin.');
                }

                if ($user->role === 'organizer' && $user->approval_status === 'rejected') {
                    Auth::logout();
                    return redirect('/login')->with('error', 'Maaf, pendaftaran Organizer Anda ditolak.');
                }

                // Jika lolos semua, silakan masuk
                return $next($request);
            }
        }

        // Tendang kalau tidak punya akses
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}