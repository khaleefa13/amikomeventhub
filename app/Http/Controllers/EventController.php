<?php

namespace App\Http\Controllers;

use App\Models\Event; 
use App\Models\Transaction; // 👈 Wajib ditambahkan agar bisa menyimpan transaksi
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

    // 🌟 FUNGSI BARU: Memproses form dari halaman checkout dan simpan ke Database
    public function processCheckout(Request $request, $id)
    {
        // 1. Validasi inputan user
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Ambil data event
        $event = Event::findOrFail($id);

        // 3. Hitung total bayar
        $biayaLayanan = $event->harga > 0 ? 5000 : 0;
        $totalBayar = $event->harga + $biayaLayanan;

        // 4. Simpan ke database Transactions
        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => '#TRX-' . rand(10000, 99999),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalBayar,
            'status' => 'Success', // Status diset Success sebagai simulasi
        ]);

        // 5. Redirect ke halaman E-Ticket dengan membawa ID TRANSAKSI (bukan ID Event)
        return redirect()->route('ticket', $transaction->id)->with('success', 'Pembayaran berhasil!');
    }
    
    // 🌟 FUNGSI DIUBAH: Halaman E-Ticket mengambil data Transaksi
    public function ticket($id)
    {
        // Cari data Transaksi berdasarkan ID beserta relasi Event-nya
        $transaction = Transaction::with('event')->findOrFail($id);
        
        // Buka file ticket.blade.php (atau my-ticket.blade.php) sambil membawa data transaksi
        return view('ticket', compact('transaction'));
    }
}