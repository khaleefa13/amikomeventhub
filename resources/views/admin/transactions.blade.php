@extends('Layout.admin')

@section('content')
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black text-slate-800">Laporan Transaksi</h1>
        <p class="text-slate-500 font-medium mt-1">Pantau arus kas dan penjualan tiket Anda secara real-time.</p>
    </div>
    <div class="flex gap-3">
        {{-- TOMBOL EKSPOR EXCEL --}}
        <a href="{{ route('admin.transaksi.export.excel') }}" 
           class="flex items-center gap-2 px-5 py-3 border-2 border-slate-200 rounded-2xl font-bold text-slate-600 hover:border-indigo-600 hover:text-indigo-600 bg-white transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Ekspor Excel
        </a>

        {{-- TOMBOL UNDUH PDF --}}
        <a href="{{ route('admin.transaksi.export.pdf') }}" 
           class="flex items-center gap-2 px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Unduh PDF
        </a>
    </div>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    
    <div class="px-8 py-6 bg-slate-50/50 border-b flex flex-wrap gap-4 items-center justify-between">
        <div class="relative w-full md:w-96">
            <span class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="CARI ORDER ID ATAU NAMA..."
                class="w-full pl-12 pr-5 py-3 rounded-2xl border-slate-200 border bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none transition uppercase text-xs font-bold tracking-widest text-slate-700">
        </div>
        
        <div class="flex gap-3 w-full md:w-auto">
            <select class="flex-1 md:flex-none px-5 py-3 rounded-2xl border-slate-200 border bg-white outline-none text-xs font-black uppercase tracking-widest text-slate-600 focus:border-indigo-500 transition-all cursor-pointer">
                <option>Semua Status</option>
                <option>Success</option>
                <option>Pending</option>
                <option>Expired</option>
            </select>
            <select class="flex-1 md:flex-none px-5 py-3 rounded-2xl border-slate-200 border bg-white outline-none text-xs font-black uppercase tracking-widest text-slate-600 focus:border-indigo-500 transition-all cursor-pointer">
                <option>Bulan Ini</option>
                <option>Bulan Lalu</option>
                <option>Tahun 2024</option>
            </select>
        </div>
    </div>

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
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-50">
                
                {{-- Baris 1 --}}
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-xl text-xs border border-indigo-100">#TRX-99210</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800 text-sm">Donni Prabowo</p>
                        <p class="text-xs text-slate-400 font-medium">donni@example.com</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-600 text-sm uppercase tracking-tight">Jazz Night 2024</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-bold text-slate-500">26 MAR 2024</p>
                        <p class="text-[10px] text-slate-400">17:45 WIB</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-emerald-200">Success</span>
                    </td>
                    <td class="px-8 py-6 text-right font-black text-slate-900">
                        Rp 155.000
                    </td>
                </tr>

                {{-- Baris 2 --}}
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl text-xs border border-slate-200">#TRX-99209</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800 text-sm">Maya Sari</p>
                        <p class="text-xs text-slate-400 font-medium">maya@example.com</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-600 text-sm uppercase tracking-tight">AI & Future Workshop</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-bold text-slate-500">26 MAR 2024</p>
                        <p class="text-[10px] text-slate-400">15:20 WIB</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="inline-block px-4 py-1.5 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-amber-200">Pending</span>
                    </td>
                    <td class="px-8 py-6 text-right font-black text-slate-900">
                        Rp 55.000
                    </td>
                </tr>

                {{-- Baris 3 --}}
                <tr class="hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-xl text-xs border border-indigo-100">#TRX-99208</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800 text-sm">Budi Santoso</p>
                        <p class="text-xs text-slate-400 font-medium">budi@example.com</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-600 text-sm uppercase tracking-tight">Hackathon 2024</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-bold text-slate-500">25 MAR 2024</p>
                        <p class="text-[10px] text-slate-400">10:00 WIB</p>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="inline-block px-4 py-1.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest ring-1 ring-slate-200">Free</span>
                    </td>
                    <td class="px-8 py-6 text-right font-black text-slate-900">
                        Rp 0
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div class="px-8 py-6 bg-slate-50/50 border-t flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Menampilkan <span class="text-slate-800">3</span> dari <span class="text-slate-800">124</span> transaksi</p>
        
        <div class="flex items-center gap-2">
            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-400 hover:text-indigo-600 hover:border-indigo-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-md shadow-indigo-200">1</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 font-bold text-sm hover:border-indigo-600 hover:text-indigo-600 transition-all">2</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 font-bold text-sm hover:border-indigo-600 hover:text-indigo-600 transition-all">3</button>
            <button class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 hover:text-indigo-600 hover:border-indigo-600 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection