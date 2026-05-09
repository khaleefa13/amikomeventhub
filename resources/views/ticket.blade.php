<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $event->nama_event }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Menyembunyikan elemen dengan class 'no-print' saat disave ke PDF / di-print */
        @media print {
            .no-print { display: none !important; }
            body { background-color: #4f46e5 !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>

<body class="bg-indigo-600 text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full">
        <!-- Success Banner -->
        <div class="text-center mb-8 no-print">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black">Pembayaran Berhasil!</h1>
            <p class="text-indigo-100 mt-2">Tiket Anda telah terbit dan siap digunakan.</p>
        </div>

        <!-- Ticket Card -->
        <div class="bg-white text-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl relative">
            <!-- Ticket Header -->
            <div class="p-8 bg-indigo-50 border-b-4 border-dashed border-indigo-100 text-center relative">
                <p class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-2">{{ $event->kategori }} Resmi</p>
                <!-- Judul Dinamis -->
                <h2 class="text-2xl font-black leading-tight">{{ $event->nama_event }}</h2>

                <!-- Ticket Side Cuts -->
                <div class="absolute -left-4 -bottom-4 w-8 h-8 bg-indigo-600 rounded-full"></div>
                <div class="absolute -right-4 -bottom-4 w-8 h-8 bg-indigo-600 rounded-full"></div>
            </div>

            <!-- Ticket Body -->
            <div class="p-8 space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Nama Pembeli</p>
                        <!-- Karena tidak pakai login, nama ini masih dummy -->
                        <p class="font-bold text-lg">Donni Prabowo</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Tanggal</p>
                        <!-- Tanggal Dinamis -->
                        <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Order ID</p>
                        <!-- Nomor Tiket Random -->
                        <p class="font-bold">TRX-{{ rand(10000, 99999) }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs font-bold uppercase mb-1">Lokasi</p>
                        <!-- Lokasi Dinamis -->
                        <p class="font-bold">{{ $event->lokasi ?? 'Amikom Yogyakarta' }}</p>
                    </div>
                </div>

                <div class="bg-slate-100 p-6 rounded-3xl flex flex-col items-center">
                    <p class="text-slate-400 text-xs font-bold uppercase mb-4">Scan QR untuk Check-in</p>
                    <!-- Mock QR Code -->
                    <div class="w-48 h-48 bg-white p-4 rounded-xl shadow-inner flex items-center justify-center">
                        <div class="w-full h-full border-4 border-slate-900 flex flex-wrap p-1">
                            <div class="w-1/4 h-1/4 bg-slate-900"></div><div class="w-1/4 h-1/4 bg-white"></div><div class="w-1/4 h-1/4 bg-slate-900"></div><div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div><div class="w-1/4 h-1/4 bg-slate-900"></div><div class="w-1/4 h-1/4 bg-white"></div><div class="w-1/4 h-1/4 bg-slate-900"></div>
                            <div class="w-1/4 h-1/4 bg-slate-900"></div><div class="w-1/4 h-1/4 bg-white"></div><div class="w-1/4 h-1/4 bg-slate-900"></div><div class="w-1/4 h-1/4 bg-white"></div>
                            <div class="w-1/4 h-1/4 bg-white"></div><div class="w-1/4 h-1/4 bg-slate-900"></div><div class="w-1/4 h-1/4 bg-white"></div><div class="w-1/4 h-1/4 bg-slate-900"></div>
                        </div>
                    </div>
                    <p class="mt-4 font-mono font-bold text-slate-800">TKT-{{ rand(1000000, 9999999) }}</p>
                </div>
            </div>

            <div class="px-8 pb-8 no-print">
                <button onclick="window.print()" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
                    Cetak / Simpan PDF
                </button>
                <a href="/" class="block text-center mt-4 text-slate-500 font-bold hover:text-indigo-600 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>