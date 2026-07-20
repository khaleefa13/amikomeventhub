<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    // Menampilkan daftar semua Organizer (HIMA)
    public function index()
    {
        // Ambil user yang rolenya 'organizer', urutkan dari yang terbaru daftar
        $organizers = User::where('role', 'organizer')->latest()->get();
        return view('admin.organizers.index', compact('organizers'));
    }

    // Fungsi untuk menyetujui akun
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approval_status' => 'approved']);
        return redirect()->back()->with('success', 'Akun Organizer berhasil disetujui!');
    }

    // Fungsi untuk menolak akun
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approval_status' => 'rejected']);
        return redirect()->back()->with('success', 'Akun Organizer telah ditolak.');
    }
}