<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $transaction->event->nama_event ?? 'Event' }}</title>

    <!-- 🌟 TAMBAHAN: Meta Tags untuk memunculkan gambar QR di Link Preview WhatsApp -->
    <meta property="og:title" content="E-Ticket - {{ $transaction->event->nama_event ?? 'Event' }}">
    <meta property="og:description" content="Pembayaran Anda berhasil! Buka tautan ini untuk melihat E-Ticket dan QR Code resmi Anda.">
    <!-- PERBAIKAN: QR Code untuk WhatsApp sekarang memuat Link Tautan -->
    <meta property="og:image" content="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(route('ticket', $transaction->id)) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        /* Menyembunyikan tombol saat disave ke PDF / di-print */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="py-10 px-4 md:px-0">

    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Home
            </a>
            <button onclick="window.print()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Simpan PDF / Print
            </button>
        </div>

        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl print-shadow-none flex flex-col md:flex-row relative">
            
            <div class="hidden md:block absolute top-0 bottom-0 left-[30%] border-l-2 border-dashed border-slate-200"></div>

            <div class="w-full md:w-[30%] bg-slate-50 p-8 flex flex-col items-center justify-center border-b-2 md:border-b-0 md:border-r-2 border-dashed border-slate-200 relative">
                <div class="absolute -top-4 -right-4 w-8 h-8 bg-[#f8fafc] rounded-full hidden md:block"></div>
                <div class="absolute -bottom-4 -right-4 w-8 h-8 bg-[#f8fafc] rounded-full hidden md:block"></div>
                
                <h3 class="font-black text-slate-800 text-xl tracking-widest mb-1">E-TICKET</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">AmikomEventHub</p>
                
                <div class="w-32 h-32 bg-white border border-slate-200 p-2 rounded-xl shadow-sm mb-4">
                    <!-- 🌟 PERBAIKAN: QR Code memuat URL Tiket, bukan Order ID lagi -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('ticket', $transaction->id)) }}" alt="QR Code" class="w-full h-full object-contain">
                </div>
                
                <!-- Status dinamis menyesuaikan database -->
                @if(strtolower($transaction->status) === 'success' || strtolower($transaction->status) === 'paid')
                    <span class="px-4 py-1.5 bg-green-100 text-green-700 font-black text-xs uppercase tracking-widest rounded-full ring-1 ring-green-200">Lunas</span>
                @elseif(strtolower($transaction->status) === 'pending')
                    <span class="px-4 py-1.5 bg-yellow-100 text-yellow-700 font-black text-xs uppercase tracking-widest rounded-full ring-1 ring-yellow-200">Pending</span>
                @else
                    <span class="px-4 py-1.5 bg-red-100 text-red-700 font-black text-xs uppercase tracking-widest rounded-full ring-1 ring-red-200">Batal/Gagal</span>
                @endif
                
                <p class="text-xs font-bold text-slate-500 mt-3">{{ $transaction->order_id }}</p>
            </div>

            <div class="w-full md:w-[70%] p-8 relative">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 font-bold text-[10px] uppercase tracking-widest rounded-lg mb-2">
                            {{ $transaction->event->kategori ?? 'Umum' }}
                        </span>
                        <h2 class="text-2xl font-black text-slate-800 leading-tight">{{ $transaction->event->nama_event }}</h2>
                    </div>
                    @if($transaction->event->poster)
                        <img src="{{ asset('storage/' . $transaction->event->poster) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm border border-slate-100">
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal & Waktu</p>
                        <p class="font-bold text-slate-700 text-sm">{{ \Carbon\Carbon::parse($transaction->event->tanggal)->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Lokasi Event</p>
                        <p class="font-bold text-slate-700 text-sm line-clamp-2">{{ $transaction->event->lokasi ?? 'Amikom Yogyakarta' }}</p>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 mt-2">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Pemesan</p>
                    <div class="bg-slate-50 p-4 rounded-2xl flex flex-col md:flex-row justify-between gap-4">
                        <div>
                            <p class="font-black text-slate-800 uppercase">{{ $transaction->customer_name }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ $transaction->customer_email }}</p>
                        </div>
                        <div class="md:text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Tiket</p>
                            <p class="font-black text-indigo-600 text-lg">1 Tiket</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <p class="text-center text-xs text-slate-400 font-medium mt-6 no-print">Tunjukkan QR Code ini pada petugas di lokasi acara.</p>

        <!-- ========================================== -->
        <!-- 🌟 AREA TAMBAHAN UNTUK FORM REVIEW (NO-PRINT) -->
        <!-- ========================================== -->
        @php
            // Mengecek apakah acara sudah lewat hari ini
            $isPastEvent = \Carbon\Carbon::parse($transaction->event->tanggal)->isPast(); 
            
            // Cek apakah user sudah mereview
            $hasReviewed = \App\Models\Review::where('transaction_id', $transaction->id)->exists();
        @endphp

        <!-- Form hanya muncul jika tiket Success, Acara sudah lewat, dan belum di-review -->
        @if(strtolower($transaction->status) == 'success' && $isPastEvent && !$hasReviewed)
            <div class="no-print mt-8 bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="font-black text-slate-800 text-xl mb-2">Bagaimana acaranya?</h3>
                <p class="text-sm text-slate-500 mb-6">Berikan ulasan Anda! Testimoni ini akan membantu penyelenggara untuk membuat acara yang lebih baik lagi.</p>
                
                <!-- Peringatan Jika Error/Sukses -->
                @if(session('success'))
                    <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl font-medium">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="p-4 mb-6 text-sm text-red-800 bg-red-50 border border-red-200 rounded-xl font-medium">{{ session('error') }}</div>
                @endif

                <form action="{{ route('review.store', $transaction->id) }}" method="POST">
                    @csrf
                    
                    <!-- Pilih Bintang -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Penilaian Bintang</label>
                        <select name="rating" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" required>
                            <!-- 🌟 PERBAIKAN: Mengembalikan format bintang yang error -->
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                            <option value="3">⭐⭐⭐ (Cukup)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Sangat Kurang)</option>
                        </select>
                    </div>

                    <!-- Komentar -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Komentar / Testimoni</label>
                        <textarea name="comment" rows="3" class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none" placeholder="Ceritakan pengalaman seru Anda di acara ini..." required></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
        @elseif($hasReviewed)
            <div class="no-print mt-8 p-6 text-center bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-3xl font-medium shadow-sm">
                <span class="text-2xl block mb-2">⭐⭐⭐⭐⭐</span>
                Terima kasih, Anda sudah memberikan ulasan untuk event ini!
            </div>
        @endif

    </div>

</body>
</html>