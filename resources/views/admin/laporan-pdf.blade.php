<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #f8fafc; color: #333; }
        .text-gray { color: #64748b; font-size: 10px; display: block; margin-top: 2px; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Pembeli</th>
                <th>Event</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $trx->order_id }}</td>
                <td>
                    <strong>{{ $trx->customer_name }}</strong>
                    <span class="text-gray">{{ $trx->customer_email }}</span>
                </td>
                <td>
                    {{ $trx->event->nama_event ?? 'Event Terhapus' }}
                </td>
                <td>{{ $trx->status }}</td>
                <td>
                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>