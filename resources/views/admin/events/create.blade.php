@extends('Layout.admin')

@section('content')
<div class="p-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Event Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi formulir di bawah ini untuk membuat acara baru.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-4xl">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Event</label>
                    <input type="text" name="nama_event" value="{{ old('nama_event') }}" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                        placeholder="Contoh: Jazz Night 2024" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Musik">Musik</option>
                        <option value="Tech">Tech</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Seminar">Seminar</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Tiket (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                        placeholder="150000" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Total Stok Tiket</label>
                    <input type="number" name="total_stok" value="{{ old('total_stok') }}" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                        placeholder="100" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Poster Event</label>
                    <input type="file" name="poster" 
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-400 mt-2 italic">*Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 mt-10 border-t border-gray-100 pt-6">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-8 rounded-lg transition shadow-lg shadow-indigo-200">
                    Simpan Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-gray-700 font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection