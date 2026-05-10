<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Transaction; // <-- GANTI INI JIKA NAMA MODEL ANDA BUKAN 'Transaction'
use App\Exports\TransactionExport;

class TransactionController extends Controller
{
    public function exportExcel()
    {
        // Pastikan Anda sudah membuat class TransactionExport sebelumnya
        return Excel::download(new TransactionExport, 'Laporan_Transaksi.xlsx');
    }

    public function exportPdf()
    {
        // Ambil semua data transaksi
        $transactions = Transaction::latest()->get(); 

        // Load view PDF yang ada di folder resources/views/admin/laporan-pdf.blade.php
        $pdf = Pdf::loadView('admin.laporan-pdf', compact('transactions'));
        
        // Atur ukuran kertas (opsional)
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('Laporan_Transaksi.pdf');
    }
}