<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Menampilkan halaman Kelola Event (Read) & Fitur Search
    public function index(Request $request)
    {
        // Memulai query builder dari model Event
        $query = Event::query();

        // Mengecek apakah parameter pencarian ada dan tidak kosong
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_event', 'LIKE', '%' . $request->search . '%');
        }

        // Mengambil hasil, diurutkan dari yang terbaru
        $events = $query->latest()->get();
        
        return view('admin.events.index', compact('events'));
    }

    // Menampilkan form tambah event (Create)
    public function create()
    {
        return view('admin.events.create');
    }

    // Menyimpan event baru (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required',
            'kategori' => 'required',
            'tanggal' => 'required|date',
            'harga' => 'required|numeric',
            'total_stok' => 'required|numeric',
            'poster' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    // Menampilkan form edit (Edit)
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // Mengupdate data event (Update)
    public function update(Request $request, Event $event)
    {
        $data = $request->all();

        if ($request->hasFile('poster')) {
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diupdate!');
    }

    // Menghapus data event (Delete)
    public function destroy(Event $event)
    {
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}