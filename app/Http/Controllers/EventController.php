<?php

namespace App\Http\Controllers;

use App\Models\Event; 
use App\Models\Transaction; 
use Illuminate\Http\Request;

// 🌟 WAJIB DITAMBAHKAN: Panggil fungsi Midtrans
use Midtrans\Config;
use Midtrans\Snap;

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

    // 🌟 FUNGSI DIUBAH: Memproses checkout, kurangi stok, dan amankan Token Midtrans
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

        // 4. Simpan ke database Transactions (Status diset PENDING)
        // Order ID ditambah time() agar dijamin 100% unik di sistem Midtrans
        $orderId = '#TRX-' . rand(10000, 99999) . '-' . time(); 
        
        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalBayar,
            'status' => 'Pending', // 👈 Diubah jadi Pending karena belum dibayar
        ]);

        // ==========================================
        // 🌟 PERBAIKAN STOK: Update Stok Tiket Event
        // ==========================================
        // Kurangi sisa stok sebanyak 1
        $event->decrement('total_stok', 1);
        
        // Tambah catatan tiket terjual sebanyak 1
        $event->increment('stok_terjual', 1);
        // ==========================================

        // ==========================================
        // 5. KONFIGURASI & PROSES MIDTRANS
        // ==========================================
        
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Memaklumi SSL jika dijalankan di localhost (Laragon/Windows)
        // Ditambah CURLOPT_HTTPHEADER kosong agar Midtrans tidak error di PHP 8.4
        // PENTING: Beri tanda komentar (//) pada Config::$curlOptions ini saat nanti diunggah ke hosting!
        //Config::$curlOptions = [
           // CURLOPT_SSL_VERIFYPEER => false, 
           // CURLOPT_SSL_VERIFYHOST => false,
            //CURLOPT_HTTPHEADER => [] 
       // ];

        // Susun daftar belanjaan agar Midtrans bisa menghitung tagihan dengan valid
        $itemDetails = [
            [
                'id' => $event->id,
                'price' => $event->harga,
                'quantity' => 1,
                'name' => substr($event->nama_event, 0, 50), // Batas maksimal karakter Midtrans
            ]
        ];

        // Jika ada biaya layanan, masukkan sebagai item terpisah di struk Midtrans
        if ($biayaLayanan > 0) {
            $itemDetails[] = [
                'id' => 'FEE-01',
                'price' => $biayaLayanan,
                'quantity' => 1,
                'name' => 'Biaya Layanan App',
            ];
        }

        // Siapkan parameter lengkap yang akan dikirim ke server Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalBayar,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
            'item_details' => $itemDetails
        ];

        // Dapatkan Snap Token (Tiket antrean pop-up) dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // 6. Redirect ke halaman pembayaran (payment.blade.php) bukan langsung ke e-ticket
        return view('payment', compact('snapToken', 'transaction', 'event'));
    }
    
    // Halaman E-Ticket mengambil data Transaksi
    public function ticket($id)
    {
        // Cari data Transaksi berdasarkan ID beserta relasi Event-nya
        $transaction = Transaction::with('event')->findOrFail($id);
        
        // Buka file ticket.blade.php sambil membawa data transaksi
        return view('ticket', compact('transaction'));
    }
}