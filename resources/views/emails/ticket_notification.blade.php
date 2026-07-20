<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket Anda - AmikomEventHub</title>
</head>
<body style="font-family: 'Arial', sans-serif; color: #333333; line-height: 1.6; background-color: #f8fafc; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0;">
        <h2 style="color: #4f46e5; margin-bottom: 5px;">Halo, {{ $transaction->customer_name }}!</h2>
        <p style="font-size: 14px; color: #64748b;">Pembayaran Anda telah diverifikasi. Berikut adalah bukti e-ticket resmi Anda:</p>
        
        <div style="background-color: #f8fafc; padding: 20px; border-radius: 12px; margin: 20px 0; border: 1px solid #f1f5f9;">
            <p style="margin: 5px 0; font-size: 14px;"><strong>Nomor Invoice:</strong> {{ $transaction->order_id }}</p>
            <p style="margin: 5px 0; font-size: 14px;"><strong>Nama Event:</strong> {{ $transaction->event->nama_event }}</p>
            <p style="margin: 5px 0; font-size: 14px;"><strong>Total Bayar:</strong> Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        </div>

        <p style="font-size: 14px; margin-bottom: 25px;">Silakan klik tombol di bawah ini untuk melihat E-Ticket resmi Anda yang dilengkapi dengan QR Code untuk ditunjukkan saat masuk ke acara:</p>
        
        <p style="text-align: center;">
            <a href="{{ route('ticket', $transaction->id) }}" style="display: inline-block; padding: 14px 28px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 12px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">Lihat & Unduh E-Ticket</a>
        </p>

        <p style="font-size: 11px; color: #94a3b8; margin-top: 40px; text-align: center; border-top: 1px solid #f1f5f9; padding-top: 15px;">
            Email ini dikirim otomatis oleh sistem AmikomEventHub. Mohon untuk tidak membalas email ini.
        </p>
    </div>
</body>
</html>