<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tiket - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8 text-center border border-slate-100">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-6">Tiket: <span class="font-bold text-indigo-600">{{ $event->nama_event }}</span></p>
        
        <div class="bg-slate-50 p-4 rounded-xl mb-8 border border-slate-100">
            <p class="text-sm text-slate-500 mb-1">Total Tagihan</p>
            <p class="text-3xl font-black text-slate-800">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        </div>

        <button id="pay-button" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
            Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        // Trigger Pop-up Midtrans saat tombol diklik
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    // Arahkan ke halaman tiket jika sukses
                    window.location.href = "/ticket/{{ $transaction->id }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup jendela pembayaran sebelum menyelesaikannya');
                }
            });
        };
    </script>
</body>
</html>