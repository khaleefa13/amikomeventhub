@extends('layout.app')

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-12 md:py-20 flex flex-col md:flex-row items-center gap-10 md:gap-12">
        <div class="flex-1 space-y-6 md:space-y-8 text-center md:text-left">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs md:text-sm font-bold uppercase tracking-wider">
                #1 Event Platform
            </span>
            
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <br class="hidden md:block" /> <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            
            <p class="text-base md:text-lg text-slate-500 max-w-lg mx-auto md:mx-0 leading-relaxed px-4 md:px-0">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4 pt-2 md:pt-0">
                <a href="#events" class="px-8 py-3.5 md:py-4 bg-indigo-600 text-white rounded-2xl font-bold text-base md:text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform w-full sm:w-auto">
                    Mulai Jelajah
                </a>
                <a href="#" class="px-8 py-3.5 md:py-4 border-2 border-slate-200 rounded-2xl font-bold text-base md:text-lg hover:border-indigo-600 hover:text-indigo-600 transition w-full sm:w-auto">
                    Cara Pesan
                </a>
            </div>
        </div>
        
        <div class="flex-1 relative w-full mt-8 md:mt-0">
            <div class="absolute -top-10 -left-10 w-48 md:w-64 h-48 md:h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-10 -right-10 w-48 md:w-64 h-48 md:h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <img src="assets/concert.png" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] md:aspect-[4/5] object-center">

            <div class="absolute -bottom-4 md:-bottom-6 -left-4 md:-left-6 right-4 md:right-auto bg-white/90 backdrop-blur p-4 md:p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 flex-shrink-0 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] md:text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="text-sm md:text-base font-bold leading-tight">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="text-center mb-8 md:mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Jelajahi Kategori</h2>
            <p class="text-sm md:text-base text-slate-500 font-medium">Temukan event yang paling sesuai dengan minat dan passion-mu.</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-3 md:gap-4">
            <a href="{{ route('home') }}#events" 
               class="px-5 md:px-6 py-2.5 md:py-3 border rounded-xl md:rounded-2xl text-sm md:text-base font-bold transition-all shadow-sm 
               {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-600' }}">
                Semua
            </a>

            @isset($categories)
                @foreach($categories as $kategori)
                <a href="{{ route('home', ['category' => $kategori]) }}#events" 
                   class="px-5 md:px-6 py-2.5 md:py-3 border rounded-xl md:rounded-2xl text-sm md:text-base font-bold transition-all shadow-sm 
                   {{ request('category') == $kategori ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white border-slate-200 text-slate-600 hover:border-indigo-500 hover:bg-indigo-50 hover:text-indigo-600' }}">
                    {{ $kategori }}
                </a>
                @endforeach
            @endisset
        </div>
    </section>

    <section id="events" class="max-w-7xl mx-auto px-6 py-16 md:py-20 border-t border-slate-100 mt-6 md:mt-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 md:mb-12 gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-sm md:text-base text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            @isset($events)
                @forelse($events as $event)
                    <div class="group bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col">
                        <div class="relative overflow-hidden aspect-[4/5] md:aspect-[3/4]">
                            @if($event->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->nama_event }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold uppercase tracking-widest">
                                    No Image
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 px-3 py-1 bg-white/95 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600 shadow-sm">
                                {{ $event->kategori }}
                            </div>
                        </div>
                        
                        <div class="p-6 flex flex-col flex-1 justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-3 group-hover:text-indigo-600 transition line-clamp-2 leading-tight">{{ $event->nama_event }}</h3>
                                <div class="flex items-center gap-2 text-slate-500 text-sm mb-4 font-medium">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center pt-5 border-t border-slate-100 mt-2">
                                <span class="text-2xl font-black text-indigo-600">
                                    {{ $event->harga == 0 ? 'Gratis' : 'Rp ' . number_format($event->harga, 0, ',', '.') }}
                                </span>
                                <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition whitespace-nowrap text-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-slate-50 rounded-[2rem] border border-dashed border-slate-200">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-800 font-bold text-lg">Belum ada event saat ini</p>
                        <p class="text-slate-500 mt-1">Cek kembali secara berkala untuk event-event seru lainnya!</p>
                    </div>
                @endforelse
            @endisset
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-16 md:py-20 border-t border-slate-100">
        <div class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-3xl font-extrabold mb-2">Didukung Oleh</h2>
            <p class="text-sm md:text-base text-slate-500 font-medium">Platform kami bangga berkolaborasi dengan partner-partner luar biasa.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6 items-center justify-center">
            @isset($partners)
                @forelse($partners as $partner)
                    <div class="bg-white p-4 md:p-6 rounded-[1.5rem] md:rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center justify-center hover:shadow-xl transition-all duration-300 group aspect-square hover:-translate-y-1">
                        @if($partner->logo_url)
                            <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="{{ $partner->name }}" class="w-16 h-16 md:w-20 md:h-20 object-contain filter grayscale opacity-60 group-hover:filter-none group-hover:opacity-100 transition-all duration-300">
                        @else
                            <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-50 rounded-xl flex items-center justify-center text-[10px] font-bold text-slate-400 border border-slate-200 uppercase tracking-widest mb-2 transition-all group-hover:border-indigo-300 group-hover:text-indigo-400">No Img</div>
                        @endif
                        <span class="mt-3 md:mt-5 text-xs md:text-sm font-bold text-slate-500 group-hover:text-indigo-600 text-center transition-colors line-clamp-1">{{ $partner->name }}</span>
                    </div>
                @empty
                    <div class="col-span-full py-10 md:py-12 bg-slate-50 border border-dashed border-slate-200 rounded-[2rem] text-center">
                        <p class="text-sm md:text-base text-slate-500 font-bold">Belum ada partner yang bergabung saat ini.</p>
                    </div>
                @endforelse
            @endisset
        </div>
    </section>
@endsection