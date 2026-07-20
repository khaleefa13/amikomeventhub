<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transaction; 
use App\Models\Event; // 🌟 Panggil model Event
use App\Exports\TransactionExport;
use Illuminate\Support\Facades\Log; 

// 🌟 PANGGIL KOMPONEN EMAIL & WHATSAPP
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\SendTicketMail;

class TransactionController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new TransactionExport, 'Laporan_Transaksi.xlsx');
    }

    public function exportPdf()
    {
        $transactions = Transaction::latest()->get(); 
        $pdf = Pdf::loadView('admin.laporan-pdf', compact('transactions'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('Laporan_Transaksi.pdf');
    }

    // =================================================================
    // 🌟 PENERIMA LAPORAN DARI MIDTRANS
    // =================================================================
    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        Log::info('--- MIDTRANS DATANG ---');
        Log::info('Order ID: ' . $request->order_id . ' | Status: ' . $request->transaction_status);

        if ($hashed == $request->signature_key) {
            
            $transaction = Transaction::where('order_id', $request->order_id)->first();

            if ($transaction) {
                // JIKA STATUS LUNAS
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    
                    // Pastikan tidak mengirim WA/Email dobel jika Midtrans lapor 2 kali
                    if (strtolower($transaction->status) !== 'success') {
                        $transaction->update(['status' => 'Success']); 
                        Log::info('Status Berhasil Diubah ke SUCCESS');

                        // 🚀 JALANKAN MESIN KIRIM WA & EMAIL
                        $this->kirimNotifikasiTiket($transaction);
                    }
                } 
                // JIKA BATAL / KEDALUWARSA
                elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                    if (strtolower($transaction->status) !== 'failed') {
                        $transaction->update(['status' => 'Failed']); 
                        Log::info('Status Berhasil Diubah ke FAILED');

                        // Kembalikan Stok Tiket
                        $event = Event::find($transaction->event_id);
                        if ($event) {
                            $event->increment('total_stok', 1);
                            $event->decrement('stok_terjual', 1);
                        }
                    }
                }
            } else {
                Log::error('GAGAL: Data Transaksi dengan Order ID ' . $request->order_id . ' TIDAK DITEMUKAN!');
            }
        } else {
            Log::error('GAGAL: Kunci Keamanan TIDAK COCOK.');
        }

        return response()->json(['message' => 'Laporan Diterima'], 200);
    }

    // ==========================================
    // 🌟 MESIN PENGIRIM EMAIL & WHATSAPP
    // ==========================================
    private function kirimNotifikasiTiket($transaction)
    {
        // Pastikan data event ikut terbaca
        $transaction->load('event');

        // 1. Eksekusi Kirim Email
        try {
            Mail::to($transaction->customer_email)->send(new SendTicketMail($transaction));
            Log::info('Email sukses dikirim ke: ' . $transaction->customer_email);
        } catch (\Exception $e) {
            Log::error('Email Gagal: ' . $e->getMessage());
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
                           "Silakan buka link di bawah ini untuk melihat dan menyimpan *E-Ticket resmi dengan QR Code* Anda:\n" .
                           route('ticket', $transaction->id) . "\n\n" .
                           "Sampai jumpa di lokasi acara!\n\n---\n_Pesan otomatis oleh AmikomEventHub_";

                Http::withHeaders([
                    'Authorization' => $tokenWA
                ])->post('https://api.fonnte.com/send', [
                    'target' => $transaction->customer_phone,
                    'message' => $pesanWA,
                    'countryCode' => '62' 
                ]);
                Log::info('WA sukses dikirim ke: ' . $transaction->customer_phone);
            } else {
                Log::warning('Token Fonnte belum diisi di file .env');
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp Gagal: ' . $e->getMessage());
        }
    }
}