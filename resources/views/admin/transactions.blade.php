@extends('Layout.admin')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black text-slate-800">Laporan Transaksi</h1>
        <p class="text-slate-500 font-medium mt-1">Pantau arus kas dan penjualan tiket Anda secara real-time.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.transaksi.export.excel') }}" class="flex items-center gap-2 px-5 py-3 border-2 border-slate-200 rounded-2xl font-bold text-slate-600 hover:border-indigo-600 hover:text-indigo-600 bg-white transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Ekspor Excel
        </a>
        <a href="{{ route('admin.transaksi.export.pdf') }}" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            Unduh PDF
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 px-6 py-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold flex items-center gap-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    
    <form action="{{ route('admin.transactions') }}" method="GET" class="px-8 py-6 bg-slate-50/50 border-b flex flex-wrap gap-4 items-center justify-between">
        <div class="relative w-full md:w-96">
            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI ORDER ID ATAU NAMA..."
                class="w-full pl-12 pr-5 py-3 rounded-2xl border-slate-200 border bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition uppercase text-xs font-bold tracking-widest text-slate-700">
            <button type="submit" class="hidden"></button>
        </div>
        
        <div class="flex gap-3 w-full md:w-auto">
            <select name="status" onchange="this.form.submit()" class="flex-1 md:flex-none px-5 py-3 rounded-2xl border-slate-200 border bg-white outline-none text-xs font-black uppercase tracking-widest text-slate-600 focus:border-indigo-500 transition-all cursor-pointer">
                <option value="Semua Status" {{ request('status') == 'Semua Status' ? 'selected' : '' }}>Semua Status</option>
                <option value="Success" {{ request('status') == 'Success' ? 'selected' : '' }}>Success</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                <option value="Free" {{ request('status') == 'Free' ? 'selected' : '' }}>Free</option>
            </select>
            
            <select name="date_filter" onchange="this.form.submit()" class="flex-1 md:flex-none px-5 py-3 rounded-2xl border-slate-200 border bg-white outline-none text-xs font-black uppercase tracking-widest text-slate-600 focus:border-indigo-500 transition-all cursor-pointer">
                <option value="Semua Waktu" {{ request('date_filter') == 'Semua Waktu' ? 'selected' : '' }}>Semua Waktu</option>
                <option value="Bulan Ini" {{ request('date_filter') == 'Bulan Ini' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="Bulan Lalu" {{ request('date_filter') == 'Bulan Lalu' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="Tahun Ini" {{ request('date_filter') == 'Tahun Ini' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">
                    <th class="px-8 py-5">Order ID</th>
                    <th class="px-8 py-5">Detail Pembeli</th>
                    <th class="px-8 py-5">Event</th>
                    <th class="px-8 py-5">Tgl Transaksi</th>
                    <th class="px-8 py-5 text-center">Status</th>
                    <th class="px-8 py-5 text-right">Total Tagihan</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-50">
                @forelse($transactions as $trx)
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-xl text-xs border border-indigo-100">
                            {{ $trx->order_id }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800 text-sm">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-400 font-medium">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-600 text-sm uppercase tracking-tight">
                            {{ $trx->event->nama_event ?? 'Event Terhapus' }}
                        </p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-bold text-slate-500">{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y') }}</p>
                        <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($trx->created_at)->format('H:i') }} WIB</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        @if(strtolower($trx->status) == 'success')
                            <span class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-emerald-200">Success</span>
                        @elseif(strtolower($trx->status) == 'pending')
                            <span class="inline-block px-4 py-1.5 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-amber-200">Pending</span>
                        @elseif(strtolower($trx->status) == 'free')
                            <span class="inline-block px-4 py-1.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-slate-200">Free</span>
                        @else
                            <span class="inline-block px-4 py-1.5 bg-rose-100 text-rose-700 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-rose-200">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right font-black text-slate-900">
                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.transactions.edit', $trx->id) }}" title="Edit" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Data tidak dapat dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus" class="p-2 bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <p class="text-slate-500 font-bold">Tidak ada data transaksi yang ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-slate-50/50 border-t">
        {{ $transactions->withQueryString()->links() }}
    </div>
</div>
@endsection