@extends('Layout.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-800">Edit Partner</h1>
    <p class="text-slate-500 font-medium mt-1">Ubah informasi partner {{ $partner->name }}.</p>
</div>

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-8 max-w-2xl">
    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
            <input type="text" name="name" value="{{ old('name', $partner->name) }}" required placeholder="Masukkan nama partner" class="w-full px-4 py-3 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-slate-700 font-medium">
            @error('name') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2">Logo Saat Ini</label>
            @if($partner->logo_url)
                <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="Logo" class="w-32 h-32 object-contain rounded-xl border border-slate-200 p-2 mb-4 bg-slate-50">
            @else
                <p class="text-sm text-slate-500 mb-4">Belum ada logo terunggah.</p>
            @endif

            <label class="block text-sm font-bold text-slate-700 mb-2">Ganti Logo Partner (Opsional)</label>
            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-slate-50 transition">
                <input type="file" name="logo_url" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition cursor-pointer">
                <span class="text-xs text-slate-400 mt-2 font-medium">Abaikan jika tidak ingin mengganti logo</span>
            </div>
            @error('logo_url') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-2xl transition shadow-lg shadow-indigo-200">
                Update Data
            </button>
            <a href="{{ route('admin.partners.index') }}" class="py-3 px-6 text-slate-500 font-bold hover:bg-slate-100 rounded-2xl transition">Batal</a>
        </div>
    </form>
</div>
@endsection