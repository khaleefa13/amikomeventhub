@extends('Layout.admin')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-black text-slate-800">Kelola Partner</h1>
        <p class="text-slate-500 font-medium mt-1">Kelola daftar sponsor dan partner kolaborasi Anda.</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl flex items-center gap-2 transition shadow-lg shadow-indigo-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Partner
    </a>
</div>

<!-- FORM PENCARIAN PARTNER -->
<div class="flex flex-col md:flex-row gap-4 mb-8">
    <form action="{{ route('admin.partners.index') }}" method="GET" class="flex-1 relative w-full md:max-w-md">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <!-- Input pencarian dengan name="search" dan value dari request -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama partner (tekan Enter)..." class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 bg-white font-medium text-sm transition-all text-slate-700">
        
        <!-- Tombol submit tersembunyi agar form disubmit saat Enter -->
        <button type="submit" class="hidden"></button>
    </form>
</div>
<!-- AKHIR FORM PENCARIAN -->

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-widest border-b border-slate-100">
                    <th class="py-5 px-8">No</th>
                    <th class="py-5 px-8">Logo</th>
                    <th class="py-5 px-8">Nama Partner</th>
                    <th class="py-5 px-8 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-50 text-sm">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="py-6 px-8 text-slate-500 font-bold">{{ $index + 1 }}</td>
                    <td class="py-6 px-8">
                        @if($partner->logo_url)
                            <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="{{ $partner->name }}" class="w-16 h-16 object-contain rounded-xl shadow-sm border border-slate-200 bg-white p-1">
                        @else
                            <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] font-bold text-slate-400 border border-slate-200 uppercase tracking-widest">No Img</div>
                        @endif
                    </td>
                    <td class="py-6 px-8">
                        <div class="font-bold text-slate-800 text-base mb-1 capitalize">{{ $partner->name }}</div>
                        <div class="text-xs text-slate-500 font-medium">Ditambahkan: {{ $partner->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="py-6 px-8">
                        <div class="flex justify-center gap-3">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus partner ini?');">
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
                    <td colspan="4" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <!-- Logika tampilan jika pencarian tidak ditemukan vs jika tabel memang kosong -->
                            <p class="text-slate-800 font-black text-lg">
                                {{ request('search') ? 'Partner tidak ditemukan' : 'Belum ada partner' }}
                            </p>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ request('search') ? 'Coba gunakan kata kunci lain.' : 'Klik tombol "Tambah Partner" untuk menambahkan.' }}
                            </p>

                            <!-- Tombol untuk reset filter pencarian -->
                            @if(request('search'))
                                <a href="{{ route('admin.partners.index') }}" class="mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition">
                                    Tampilkan Semua Partner
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection