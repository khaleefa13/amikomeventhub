<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, $eventId)
    {
        // 1. Validasi input nama, bintang & komentar
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        // Pastikan event-nya ada di database
        $event = Event::findOrFail($eventId);

        // 2. Simpan ke database
        Review::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        // 3. Kembalikan ke halaman dengan pesan sukses
        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}