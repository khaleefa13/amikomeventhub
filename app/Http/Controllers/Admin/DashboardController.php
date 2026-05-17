<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; 
use App\Models\Event; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // FUNGSI UNTUK HALAMAN DASHBOARD UTAMA
    public function index()
    {
        // Menggunakan 'total_price' sesuai database
        $totalPendapatan = Transaction::where('status', 'Success')->sum('total_price');

        $tiketTerjual = Transaction::where('status', 'Success')->count();
        $eventAktif = Event::whereDate('tanggal', '>=', Carbon::today())->count();
        $pesananPending = Transaction::where('status', 'Pending')->count();

        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPendapatan', 
            'tiketTerjual', 
            'eventAktif', 
            'pesananPending', 
            'recentTransactions'
        )); 
    }

    // FUNGSI UNTUK HALAMAN LAPORAN TRANSAKSI (Read & Filter)
    public function transactions(Request $request)
    {
        $query = Transaction::with('event');

        // Menggunakan 'customer_name' dan 'customer_email' sesuai database
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            $now = Carbon::now();

            if ($dateFilter === 'Bulan Ini') {
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
            } elseif ($dateFilter === 'Bulan Lalu') {
                $query->whereMonth('created_at', $now->subMonth()->month)
                      ->whereYear('created_at', $now->subMonth()->year);
            } elseif ($dateFilter === 'Tahun Ini') {
                $query->whereYear('created_at', $now->year);
            }
        }

        $transactions = $query->latest()->paginate(10);

        return view('admin.transactions', compact('transactions'));
    }

    // FUNGSI UNTUK MENAMPILKAN FORM EDIT TRANSAKSI
    public function editTransaction($id)
    {
        // Ambil data transaksi berdasarkan ID beserta relasi event-nya
        $transaction = Transaction::with('event')->findOrFail($id);
        
        return view('admin.transactions_edit', compact('transaction'));
    }

    // FUNGSI UNTUK MENYIMPAN PERUBAHAN TRANSAKSI
    public function updateTransaction(Request $request, $id)
    {
        // Validasi inputan dari admin
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'status' => 'required|in:Success,Pending,Expired,Free',
        ]);

        // Cari transaksi dan update datanya
        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transactions')->with('success', 'Data transaksi berhasil diperbarui!');
    }

    // FUNGSI UNTUK MENGHAPUS TRANSAKSI
    public function destroyTransaction($id)
    {
        // Cari transaksi lalu hapus
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('admin.transactions')->with('success', 'Data transaksi berhasil dihapus!');
    }
}