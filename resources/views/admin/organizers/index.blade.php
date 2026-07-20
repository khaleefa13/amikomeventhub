@extends('Layout.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-800 mb-2">Kelola Organizer</h1>
    <p class="text-slate-500">Persetujuan pendaftaran akun Kepanitiaan / HIMA.</p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-medium">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest">
                    <th class="p-4 font-bold border-b border-slate-100">Nama Organisasi</th>
                    <th class="p-4 font-bold border-b border-slate-100">Email</th>
                    <th class="p-4 font-bold border-b border-slate-100">Status</th>
                    <th class="p-4 font-bold border-b border-slate-100">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($organizers as $org)
                <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                    <td class="p-4 font-bold text-slate-800">{{ $org->name }}</td>
                    <td class="p-4 text-slate-500">{{ $org->email }}</td>
                    <td class="p-4">
                        @if($org->approval_status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 font-bold text-[10px] uppercase tracking-widest rounded-lg">Pending</span>
                        @elseif($org->approval_status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-700 font-bold text-[10px] uppercase tracking-widest rounded-lg">Disetujui</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 font-bold text-[10px] uppercase tracking-widest rounded-lg">Ditolak</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($org->approval_status === 'pending')
                            <div class="flex gap-2">
                                <form action="{{ route('admin.organizers.approve', $org->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1.5 bg-indigo-600 text-white font-bold text-xs rounded-lg hover:bg-indigo-700">Setujui</button>
                                </form>
                                <form action="{{ route('admin.organizers.reject', $org->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1.5 bg-red-100 text-red-600 font-bold text-xs rounded-lg hover:bg-red-200">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-slate-400 italic text-xs">Telah diproses</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-500">Belum ada Organizer yang mendaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection