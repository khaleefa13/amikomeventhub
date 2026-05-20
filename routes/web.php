<?php

use Illuminate\Support\Facades\Route;

// --- Controllers Auth ---
use App\Http\Controllers\AuthController;

// --- Controllers User Area ---
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\EventController; 

// --- Controllers Admin Area ---
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController; 
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\TransactionController;

// ==========================================
// RUTE USER AREA & HALAMAN STATIS (PUBLIK)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Fitur Interaksi User (Detail Event, Checkout, & Tiket)
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/process', [EventController::class, 'processCheckout'])->name('checkout.process');
Route::get('/ticket/{id}', [EventController::class, 'ticket'])->name('ticket');

// ==========================================
// RUTE AUTHENTICATION (LOGIN / LOGOUT)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// RUTE ADMIN AREA (DIKUNCI DENGAN MIDDLEWARE 'auth')
// ==========================================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Event, Kategori & Partner
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::resource('events', AdminEventController::class);
    Route::resource('partners', PartnerController::class);
    
    // Laporan Transaksi & Ekspor Data
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transaksi.export.excel');
    Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transaksi.export.pdf');
    
    // Edit & Hapus Transaksi
    Route::get('/transactions/{id}/edit', [DashboardController::class, 'editTransaction'])->name('transactions.edit');
    Route::put('/transactions/{id}', [DashboardController::class, 'updateTransaction'])->name('transactions.update');
    Route::delete('/transactions/{id}', [DashboardController::class, 'destroyTransaction'])->name('transactions.destroy');

});