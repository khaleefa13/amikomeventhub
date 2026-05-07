<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Ini fungsi untuk halaman Dashboard
    public function index()
    {
        return view('admin.dashboard'); 
    }

    // 👇 TAMBAHKAN FUNGSI INI UNTUK HALAMAN TRANSAKSI 👇
    public function transactions()
    {
        return view('admin.transactions');
    }
}