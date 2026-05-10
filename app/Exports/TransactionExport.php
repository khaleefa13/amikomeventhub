<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Mengambil SEMUA data transaksi dari database tanpa pilih-pilih kolom
        return Transaction::all();
    }

    public function headings(): array
    {
        // Header ini bisa disesuaikan nanti setelah Anda melihat hasil Excel-nya
        return [
            'ID',
            'User ID',
            'Event ID',
            'Order ID',
            'Total Harga',
            'Status',
            'Dibuat Pada',
            'Diupdate Pada'
        ];
    }
}
