@extends('Layout.admin')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-slate-800">Kelola Event</h1>
        <p class="text-slate-500 font-medium mt-1">Buat, atur, dan pantau acara seru Anda di sini.</p>
    </div>
    <a href="{{ route('admin.events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl flex items-center gap-2 transition shadow-lg shadow-indigo-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Event Baru
    </a>
</div>

<div class="flex flex-col md:flex-row gap-4 mb-8">
    <div class="flex-1 relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" placeholder="Cari nama event..." class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 bg-white font-medium text-sm transition-all text-slate-700">
    </div>
    <select class="border border-slate-200 rounded-2xl px-5 py-3 bg-white focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 text-sm font-bold text-slate-600 transition-all cursor-pointer w-full md:w-auto">
        <option>Semua Kategori</option>
        <option>Musik</option>
        <option>Tech</option>
        <option>Workshop</option>
        <option>Seminar</option>
    </select>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-widest border-b border-slate-100">
                    <th class="py-5 px-8">No</th>
                    <th class="py-5 px-8">Poster</th>
                    <th class="py-5 px-8">Event</th>
                    <th class="py-5 px-8">Harga / Stok</th>
                    <th class="py-5 px-8 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-50 text-sm">
                @forelse($events as $index => $event)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="py-6 px-8 text-slate-500 font-bold">{{ $index + 1 }}</td>
                    <td class="py-6 px-8">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" class="w-14 h-20 object-cover rounded-xl shadow-sm border border-slate-200">
                        @else
                            <div class="w-14 h-20 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] font-bold text-slate-400 border border-slate-200 uppercase tracking-widest">No Img</div>
                        @endif
                    </td>
                    <td class="py-6 px-8">
                        <div class="font-bold text-slate-800 text-base mb-1 capitalize">{{ $event->nama_event }}</div>
                        <div class="text-xs text-slate-500 font-medium flex items-center gap-2">
                            <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-md font-bold">{{ $event->kategori }}</span>
                            <span>•</span>
                            <span>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}</span>
                        </div>
                    </td>
                    <td class="py-6 px-8">
                        <div class="font-black text-indigo-600 text-base mb-1">Rp {{ number_format($event->harga, 0, ',', '.') }}</div>
                        <div class="text-xs font-medium text-slate-500">
                            Stok: <span class="font-bold {{ $event->stok_terjual >= $event->total_stok ? 'text-rose-500' : 'text-slate-700' }}">{{ $event->stok_terjual }}</span>/{{ $event->total_stok }}
                        </div>
                    </td>
                    <td class="py-6 px-8">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus event ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </div>
                            <p class="text-slate-800 font-black text-lg">Belum ada event</p>
                            <p class="text-sm text-slate-500 mt-1">Klik tombol "+ Tambah Event Baru" di kanan atas untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection