@extends('Layout.admin')

{{-- Asumsi kamu menggunakan section 'content' di dalam layouts.admin --}}
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manajemen Kategori</h2>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Tambah Kategori
        </button>
    </div>

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left w-16">No</th>
                    <th class="py-3 px-6 text-left">Nama Kategori</th>
                    <th class="py-3 px-6 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">1</td>
                    <td class="py-3 px-6 text-left">Seminar</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <button class="bg-amber-400 hover:bg-amber-500 text-white font-bold py-1 px-3 rounded text-xs">
                                Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">2</td>
                    <td class="py-3 px-6 text-left">Konser</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <button class="bg-amber-400 hover:bg-amber-500 text-white font-bold py-1 px-3 rounded text-xs">
                                Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium">3</td>
                    <td class="py-3 px-6 text-left">Workshop</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <button class="bg-amber-400 hover:bg-amber-500 text-white font-bold py-1 px-3 rounded text-xs">
                                Edit
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection