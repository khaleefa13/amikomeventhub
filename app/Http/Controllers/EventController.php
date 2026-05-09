<?php

namespace App\Http\Controllers;

use App\Models\Event; // 👈 Jangan lupa baris ini wajib ada agar terhubung ke database
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Menerima $id dari URL yang diklik
    public function show($id)
    {
        // Cari data event di database berdasarkan ID
        $event = Event::findOrFail($id);
        
        // Buka halaman event-detail dan kirimkan data $event ke sana
        return view('event-detail', compact('event'));
    }

    // Untuk halaman checkout (bawa data event-nya juga)
    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        
        return view('checkout', compact('event'));
    }
    
   public function ticket($id)
{
    // Cari data event berdasarkan ID
    $event = \App\Models\Event::findOrFail($id);
    
    // Buka file my-ticket.blade.php sambil membawa data event
    return view('ticket', compact('event'));
}
}