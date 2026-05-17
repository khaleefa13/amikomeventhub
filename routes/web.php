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
use App\Http\Controllers\Admin\PartnerController;

Route::prefix('admin')->name('admin.')->group(function () {
    // ... rute event sebelumnya ...
    
    // Rute CRUD Partner
    Route::resource('partners', PartnerController::class);
});
use App\Http\Controllers\TransactionController;

// ==========================================
// RUTE USER AREA & HALAMAN STATIS
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');


// Fitur Interaksi User
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::get('/ticket/{id}', [EventController::class, 'ticket'])->name('ticket');
// TAMBAHKAN RUTE INI UNTUK MEMPROSES DATA
Route::post('/checkout/{id}/process', [EventController::class, 'processCheckout'])->name('checkout.process');

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
    // Rute CRUD Partner
    Route::resource('partners', PartnerController::class);
    Route::get('/transactions/{id}/edit', [DashboardController::class, 'editTransaction'])->name('transactions.edit');
    Route::put('/transactions/{id}', [DashboardController::class, 'updateTransaction'])->name('transactions.update');
    Route::delete('/transactions/{id}', [DashboardController::class, 'destroyTransaction'])->name('transactions.destroy');

});
