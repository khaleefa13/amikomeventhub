<?php



use Illuminate\Support\Facades\Route;

// --- Controllers User Area ---
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\EventController; 

// --- Controllers Admin Area ---
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\CategoryController;
// Perhatikan baris di bawah ini: Kita beri alias agar tidak bentrok dengan EventController milik User
use App\Http\Controllers\Admin\EventController as AdminEventController; 

use App\Http\Controllers\TransactionController;

// ==========================================
// RUTE USER AREA & HALAMAN STATIS
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');


// Fitur Interaksi User
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{id}', [EventController::class, 'ticket'])->name('ticket');


// ==========================================
// RUTE ADMIN AREA
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::resource('events', AdminEventController::class);
    Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transaksi.export.excel');
    Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transaksi.export.pdf');

});