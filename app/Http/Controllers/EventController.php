<?php

namespace App\Http\Controllers;

use App\Models\Event; 
use App\Models\Transaction; 
use Illuminate\Http\Request;

// 🌟 PANGGIL KOMPONEN MIDTRANS & NOTIFIKASI
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\SendTicketMail;

class EventController extends Controller
{
    public function show($id)
    {
        // 🌟 PERBAIKAN: Memanggil event beserta ulasannya (diurutkan dari yang terbaru)
        $event = Event::with(['reviews' => function($query) {
            $query->latest();
        }])->findOrFail($id);
        
        return view('event-detail', compact('event'));
    }

    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('checkout', compact('event'));
    }

    public function processCheckout(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $event = Event::findOrFail($id);

        $biayaLayanan = $event->harga > 0 ? 5000 : 0;
        $totalBayar = $event->harga + $biayaLayanan;

        $orderId = 'TRX-' . rand(10000, 99999) . '-' . time();
        
        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalBayar,
            'status' => 'Pending',
        ]);

        // Kurangi stok sementara
        $event->decrement('total_stok', 1);
        $event->increment('stok_terjual', 1);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        Config::$overrideNotifUrl = url('/midtrans-callback'); 
        Config::$curlOptions = [CURLOPT_SSL_VERIFYPEER => false];

        $itemDetails = [
            [
                'id' => $event->id,
                'price' => $event->harga,
                'quantity' => 1,
                'name' => substr($event->nama_event, 0, 50),
            ]
        ];

        if ($biayaLayanan > 0) {
            $itemDetails[] = [
                'id' => 'FEE-01',
                'price' => $biayaLayanan,
                'quantity' => 1,
                'name' => 'Biaya Layanan App',
            ];
        }

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

        $snapToken = Snap::getSnapToken($params);

        return view('payment', compact('snapToken', 'transaction', 'event'));
    }
    
    public function ticket($id)
    {
        $transaction = Transaction::with('event')->findOrFail($id);

        // ==========================================
        // 🌟 SENSOR KEAMANAN TIKET
        // ==========================================
        $status = strtolower($transaction->status);

        if ($status === 'pending') {
            return redirect()->route('home')->with('error', 'Selesaikan pembayaran Anda terlebih dahulu untuk bisa melihat E-Ticket.');
        }

        if ($status === 'failed' || $status === 'cancel' || $status === 'expire') {
            return redirect()->route('home')->with('error', 'Transaksi ini telah dibatalkan atau kedaluwarsa.');
        }

        return view('ticket', compact('transaction'));
    }

    // ==========================================
    // 🌟 WEBHOOK RECEIVER MIDTRANS
    // ==========================================
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            
            if ($transaction) {
                // JIKA STATUS LUNAS
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    
                    if ($transaction->status == 'Pending') {
                        $transaction->update(['status' => 'Success']); 

                        // 🌟 JALANKAN FUNGSI KIRIM EMAIL & WA
                        $this->kirimNotifikasiTiket($transaction);
                    }
                } 
                // JIKA BATAL / KEDALUWARSA
                elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                    if ($transaction->status == 'Pending') {
                        $transaction->update(['status' => 'Failed']);

                        // Kembalikan Stok Tiket
                        $event = Event::find($transaction->event_id);
                        if ($event) {
                            $event->increment('total_stok', 1);
                            $event->decrement('stok_terjual', 1);
                        }
                    }
                }
            }
        }
        
        return response()->json(['message' => 'Notifikasi Berhasil Diterima']);
    }

    // ==========================================
    // 🌟 MESIN PENGIRIM EMAIL & WHATSAPP
    // ==========================================
    private function kirimNotifikasiTiket($transaction)
    {
        $transaction->load('event');

        // 1. Eksekusi Kirim Email
        try {
            Mail::to($transaction->customer_email)->send(new SendTicketMail($transaction));
        } catch (\Exception $e) {
            \Log::error('Email Gagal: ' . $e->getMessage());
        }

        // 2. Eksekusi Kirim WhatsApp via Fonnte
        try {
            $tokenWA = env('FONNTE_TOKEN');
            
            if ($tokenWA) {
                $pesanWA = "Halo *" . $transaction->customer_name . "*,\n\n" .
                           "Pembayaran Anda untuk event *" . $transaction->event->nama_event . "* telah *BERHASIL* diverifikasi! 🎉\n\n" .
                           "Berikut ringkasan data tiket Anda:\n" .
                           "• Nomor Struk: " . $transaction->order_id . "\n" .
                           "• Total Bayar: Rp " . number_format($transaction->total_price, 0, ',', '.') . "\n\n" .
                           "Silakan buka link di bawah ini untuk melihat dan menyimpan E-Ticket resmi Anda:\n" .
                           route('ticket', $transaction->id) . "\n\n" .
                           "Sampai jumpa di lokasi acara!\n\n---\n_Pesan otomatis oleh AmikomEventHub_";

                Http::withHeaders([
                    'Authorization' => $tokenWA
                ])->post('https://api.fonnte.com/send', [
                    'target' => $transaction->customer_phone,
                    'message' => $pesanWA,
                    
                    'url' => 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode(route('ticket', $transaction->id)),
                    
                    'countryCode' => '62' 
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp Gagal: ' . $e->getMessage());
        }
    }
}