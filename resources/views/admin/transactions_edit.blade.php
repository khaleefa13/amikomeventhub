@extends('Layout.admin')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.transactions') }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-4 hover:text-indigo-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali
    </a>
    <h1 class="text-3xl font-black text-slate-800">Edit Data Transaksi</h1>
    <p class="text-slate-500 font-medium mt-1">Perbarui informasi pembeli atau ubah status transaksi secara manual.</p>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 max-w-3xl">
    
    <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100 flex justify-between items-center">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Order ID</p>
            <p class="text-lg font-black text-indigo-600">{{ $transaction->order_id }}</p>
        </div>
        <div class="text-right">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Event Tujuan</p>
            <p class="text-lg font-black text-slate-800">{{ $transaction->event->nama_event ?? 'Event Telah Dihapus' }}</p>
        </div>
    </div>

    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pembeli</label>
            <input type="text" name="customer_name" value="{{ old('customer_name', $transaction->customer_name) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-slate-700 font-medium">
            @error('customer_name') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email Pembeli</label>
                <input type="email" name="customer_email" value="{{ old('customer_email', $transaction->customer_email) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-slate-700 font-medium">
                @error('customer_email') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon / WA</label>
                <input type="tel" name="customer_phone" value="{{ old('customer_phone', $transaction->customer_phone) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-slate-700 font-medium">
                @error('customer_phone') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Status Transaksi</label>
            <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-slate-700 font-bold bg-white">
                <option value="Success" {{ $transaction->status == 'Success' ? 'selected' : '' }}>Success (Lunas)</option>
                <option value="Pending" {{ $transaction->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                <option value="Expired" {{ $transaction->status == 'Expired' ? 'selected' : '' }}>Expired (Dibatalkan)</option>
                <option value="Free" {{ $transaction->status == 'Free' ? 'selected' : '' }}>Free (Gratis)</option>
            </select>
        </div>

        <div class="pt-6">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-2xl transition shadow-lg shadow-indigo-200 w-full md:w-auto">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection