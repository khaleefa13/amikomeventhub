<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    // Menampilkan halaman Kelola Partner (Read) & Fitur Search
    public function index(Request $request)
    {
        // Memulai query builder dari model Partner
        $query = Partner::query();

        // Mengecek apakah parameter pencarian ada dan tidak kosong
        if ($request->has('search') && $request->search != '') {
            // Memfilter berdasarkan kolom 'name' pada tabel partners
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Mengambil hasil, diurutkan dari yang terbaru
        $partners = $query->latest()->get();
        
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $partner = new Partner();
        $partner->name = $request->name;

        if ($request->hasFile('logo_url')) {
            $path = $request->file('logo_url')->store('partners', 'public');
            $partner->logo_url = $path;
        }

        $partner->save();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $partner->name = $request->name;

        if ($request->hasFile('logo_url')) {
            // Hapus logo lama jika ada
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }
            // Simpan logo baru
            $path = $request->file('logo_url')->store('partners', 'public');
            $partner->logo_url = $path;
        }

        $partner->save();

        return redirect()->route('admin.partners.index')->with('success', 'Data partner berhasil diperbarui!');
    }

    public function destroy(Partner $partner)
    {
        // Hapus file logo dari storage
        if ($partner->logo_url) {
            Storage::disk('public')->delete($partner->logo_url);
        }
        
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}