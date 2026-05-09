@extends('layout.app')

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20">
    <div class="mb-12">
        <!-- Tombol Kembali Dinamis -->
        <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-6 hover:text-indigo-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Event
        </a>
        <h1 class="text-4xl font-extrabold">Checkout</h1>
        <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    <!-- Menghitung Total Harga & Biaya Layanan Otomatis -->
    @php
        $biayaLayanan = $event->harga > 0 ? 5000 : 0;
        $totalBayar = $event->harga + $biayaLayanan;
    @endphp

    <div class="grid grid-cols-1 gap-8">
        <!-- Summary Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>
            <div class="flex gap-6 items-start">
                <!-- Gambar Dinamis -->
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->nama_event }}" class="w-24 h-24 rounded-2xl object-cover shadow-sm">
                @else
                    <div class="w-24 h-24 bg-slate-100 rounded-2xl flex items-center justify-center text-xs font-bold text-slate-400 uppercase tracking-widest shadow-sm border border-slate-200">No Img</div>
                @endif
                
                <div>
                    <!-- Judul, Tanggal, & Harga Dinamis -->
                    <h4 class="font-extrabold text-lg">{{ $event->nama_event }}</h4>
                    <p class="text-slate-500">{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }} • {{ $event->lokasi ?? 'Amikom Yogyakarta' }}</p>
                    <p class="text-indigo-600 font-bold mt-2">
                        1 x 
                        @if($event->harga == 0)
                            Gratis
                        @else
                            Rp {{ number_format($event->harga, 0, ',', '.') }}
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t space-y-3">
                <div class="flex justify-between text-slate-500 font-medium">
                    <span>Harga Tiket</span>
                    <span>
                        @if($event->harga == 0) Gratis @else Rp {{ number_format($event->harga, 0, ',', '.') }} @endif
                    </span>
                </div>
                <div class="flex justify-between text-slate-500 font-medium">
                    <span>Biaya Layanan</span>
                    <span>
                        @if($biayaLayanan == 0) Gratis @else Rp {{ number_format($biayaLayanan, 0, ',', '.') }} @endif
                    </span>
                </div>
                <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">
                    <span>Total Bayar</span>
                    <span class="text-indigo-600">
                        @if($totalBayar == 0) Gratis @else Rp {{ number_format($totalBayar, 0, ',', '.') }} @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 italic text-indigo-600 underline underline-offset-8">Data Pemesan</h3>
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" placeholder="Masukkan nama sesuai identitas" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email Aktif</label>
                        <input type="email" placeholder="contoh@gmail.com" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
                        <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">*E-Ticket akan dikirim ke email ini</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">No. WhatsApp</label>
                        <input type="tel" placeholder="08xxxxxxx" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
                    </div>
                </div>

                <button type="button" onclick="showMidtrans()" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                    Bayar Sekarang
                </button>
                <p class="text-center text-xs text-slate-400 font-medium">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.</p>
            </form>
        </div>
    </div>
</main>

<!-- Overlay Midtrans Simulation -->
<div id="midtrans-overlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-[2rem] overflow-hidden shadow-2xl animate-bounce-in">
        <div class="bg-slate-50 p-6 flex justify-between items-center border-b border-slate-200">
            <img src="https://midtrans.com/assets/img/logo-dark.png" alt="Midtrans Logo" class="h-6">
            <button onclick="hideMidtrans()" class="p-2 hover:bg-slate-200 text-slate-400 hover:text-slate-700 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path>
                </svg>
            </button>
        </div>
        <div class="p-8 text-center">
            <p class="text-slate-500 font-medium">Total Tagihan</p>
            <h2 class="text-3xl font-black text-indigo-700 my-2">
                @if($totalBayar == 0) Gratis @else Rp {{ number_format($totalBayar, 0, ',', '.') }} @endif
            </h2>
            <p class="text-xs text-slate-400 font-medium">Order ID #TRX-{{ rand(10000, 99999) }}</p>

            <div class="mt-8 space-y-4">
                <!-- Rute sudah diarahkan ke halaman E-Ticket -->
               <!-- Ubah bagian onclick ini -->
<button onclick="window.location.href='{{ route('ticket', $event->id) }}'" class="w-full py-4 border-2 border-indigo-100 rounded-2xl flex justify-between items-center px-6 hover:border-indigo-600 transition group bg-white">
                    <span class="font-bold group-hover:text-indigo-600 text-slate-700 transition">GoPay / QRIS</span>
                    <span class="text-indigo-400 group-hover:translate-x-1 transition-transform">→</span>
                </button>
                <button class="w-full py-4 border-2 border-slate-100 bg-slate-50 rounded-2xl flex justify-between items-center px-6 opacity-60 cursor-not-allowed">
                    <span class="font-bold text-slate-500">Virtual Account</span>
                    <span class="text-slate-400">→</span>
                </button>
                <button class="w-full py-4 border-2 border-slate-100 bg-slate-50 rounded-2xl flex justify-between items-center px-6 opacity-60 cursor-not-allowed">
                    <span class="font-bold text-slate-500">Kartu Debit/Kredit</span>
                    <span class="text-slate-400">→</span>
                </button>
            </div>

            <div class="mt-12 flex items-center justify-center gap-2 text-xs text-slate-400 font-bold uppercase tracking-widest">
                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                Secure Checkout by Midtrans
            </div>
        </div>
    </div>
</div>

<script>
    function showMidtrans() {
        document.getElementById('midtrans-overlay').classList.remove('hidden');
        document.getElementById('midtrans-overlay').classList.add('flex');
    }
    function hideMidtrans() {
        document.getElementById('midtrans-overlay').classList.add('hidden');
        document.getElementById('midtrans-overlay').classList.remove('flex');
    }
</script>

<style>
    @keyframes bounce-in {
        0% { transform: scale(0.9); opacity: 0; }
        70% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    .animate-bounce-in {
        animation: bounce-in 0.4s ease-out forwards;
    }
</style>
@endsection