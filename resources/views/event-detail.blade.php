@extends('layout.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- KOLOM KIRI (POSTER) -->
    <div class="lg:col-span-1">
        <div class="sticky top-32">
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->nama_event }}"
                    class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">
            @else
                <div class="w-full aspect-[3/4] bg-slate-100 rounded-[2.5rem] shadow-2xl border-8 border-white flex items-center justify-center text-slate-400 font-bold uppercase tracking-widest">
                    No Image
                </div>
            @endif

            <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="font-bold mb-4">Penyelenggara</h4>
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                        AH</div>
                    <div>
                        <p class="font-bold text-slate-800">Amikom Event Hub</p>
                        <p class="text-xs text-slate-500">Verified Organizer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN (DETAIL EVENT) -->
    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            <span
                class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                {{ $event->kategori }}
            </span>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->nama_event }}</h1>
            
            <div class="flex flex-wrap gap-6 text-slate-500 font-medium mt-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->lokasi ?? 'Amikom Yogyakarta' }}</span>
                </div>
            </div>
        </div>

        <div class="prose prose-slate max-w-none">
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            <p class="text-lg text-slate-600 leading-relaxed">
                {!! nl2br(e($event->deskripsi)) !!}
            </p>
        </div>

        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                    <h2 class="text-5xl font-black">
                        Rp {{ number_format($event->harga, 0, ',', '.') }} 
                        <span class="text-lg font-medium text-indigo-200">/ orang</span>
                    </h2>
                    <p class="mt-4 text-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sisa stok: <span class="font-bold underline">{{ $event->total_stok - $event->stok_terjual }} Tiket lagi!</span>
                    </p>
                </div>
                <div>
                    <a href="{{ route('checkout', ['id' => $event->id]) }}"
                        class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>

        <div class="space-y-4">
            <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
            <ul class="space-y-3 text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    Tiket dapat discan di pintu masuk (Check-in).
                </li>
                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>
            </ul>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 🌟 SECTION ULASAN (REVIEW) ALA GOOGLE MAPS -->
    <!-- ========================================== -->
    <div class="lg:col-span-3 mt-8 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
        <h3 class="text-2xl font-black text-slate-800 mb-6">Ulasan & Penilaian</h3>
        
        <!-- Notifikasi Sukses/Error -->
        @if(session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-200 rounded-xl font-medium">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI: Statistik & Form -->
            <div class="lg:col-span-1 flex flex-col gap-6">
                
                <!-- Banner Rating Rata-rata -->
                <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 text-center flex flex-col items-center justify-center shadow-inner">
                    @php
                        $avgRating = $event->reviews->avg('rating') ?? 0;
                        $totalReviews = $event->reviews->count();
                    @endphp
                    <h4 class="text-6xl font-black text-indigo-600 mb-2">{{ number_format($avgRating, 1) }}</h4>
                    <div class="text-yellow-400 text-2xl mb-1 tracking-widest">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($avgRating)) ⭐ @else <span class="text-slate-300">★</span> @endif
                        @endfor
                    </div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-2">{{ $totalReviews }} Ulasan</p>
                </div>

                <!-- Form Tulis Ulasan -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    <h4 class="font-black text-slate-800 mb-4">Tulis Ulasan Anda</h4>
                    <form action="{{ route('review.store', $event->id) }}" method="POST">
                        @csrf
                        
                        <!-- Input Nama -->
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Nama Anda</label>
                            <input type="text" name="name" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm" placeholder="Contoh: John Doe" required>
                        </div>

                        <!-- Input Bintang -->
                        <div class="mb-4">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Penilaian</label>
                            <select name="rating" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm text-slate-700" required>
                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                <option value="2">⭐⭐ (Kurang)</option>
                                <option value="1">⭐ (Sangat Kurang)</option>
                            </select>
                        </div>

                        <!-- Input Komentar -->
                        <div class="mb-5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Komentar / Testimoni</label>
                            <textarea name="comment" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none text-sm" placeholder="Ceritakan pengalaman seru Anda..." required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 text-sm">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>

            <!-- KOLOM KANAN: Daftar Ulasan -->
            <div class="lg:col-span-2">
                @if($totalReviews > 0)
                    <!-- Kotak dengan Scroll jika ulasan banyak -->
                    <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                        @foreach($event->reviews as $review)
                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar Inisial -->
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm">
                                        {{ strtoupper(substr($review->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h5 class="font-black text-slate-800 text-sm">{{ $review->name ?? 'Anonim' }}</h5>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="bg-slate-50 px-2.5 py-1 rounded-lg text-sm border border-slate-100">
                                    {{ str_repeat('⭐', $review->rating) }}
                                </div>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed mt-2 pl-13">
                                "{{ $review->comment }}"
                            </p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Tampilan Jika Belum Ada Ulasan -->
                    <div class="h-full flex flex-col items-center justify-center text-center p-10 bg-slate-50 rounded-2xl border-2 border-slate-200 border-dashed">
                        <span class="text-5xl mb-4">💬</span>
                        <h4 class="font-black text-slate-700 text-lg">Belum ada ulasan</h4>
                        <p class="text-sm text-slate-500 mt-2 max-w-xs">Jadilah yang pertama memberikan ulasan dan rating untuk event ini!</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

</main>
@endsection