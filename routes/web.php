<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

// --- Controllers ---
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\EventController; 
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as AdminEventController; 
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Admin\OrganizerController; // 🌟 Tambahan import Controller baru

// ==========================================
// RUTE USER & PUBLIK
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Interaksi Event
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/process', [EventController::class, 'processCheckout'])->name('checkout.process');
Route::get('/ticket/{id}', [EventController::class, 'ticket'])->name('ticket');

// Rute pengiriman Ulasan
Route::post('/ticket/{transaction_id}/review', [ReviewController::class, 'store'])->name('review.store');

// --- RUTE CALLBACK MIDTRANS (PENTING AGAR TIDAK PENDING) ---
Route::post('/midtrans-callback', [TransactionController::class, 'callback'])->name('midtrans.callback');


// ==========================================
// RUTE AUTHENTICATION
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//  Rute Pendaftaran HIMA
Route::get('/daftar-hima', [AuthController::class, 'showRegisterHima'])->name('register.hima');
Route::post('/daftar-hima', [AuthController::class, 'processRegisterHima'])->name('register.hima.process');

// Google SSO
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// ==========================================
// RUTE ADMIN & ORGANIZER (MULTI-TENANT)
// ==========================================
Route::prefix('panel')
    ->name('admin.')
    ->middleware(['auth']) // 🌟 Hanya cek login di pintu depan
    ->group(function () {
        
        // 🌟 ZONA BERSAMA (Bisa diakses Superadmin DAN Organizer/HIMA)
        Route::middleware(['role:superadmin,organizer'])->group(function () {
            
            // Dashboard
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            
            // Kelola Event
            Route::resource('events', AdminEventController::class);
            
            // Transaksi & Laporan
            Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
            Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transaksi.export.excel');
            Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transaksi.export.pdf');
            
            // Edit & Hapus Transaksi
            Route::get('/transactions/{id}/edit', [DashboardController::class, 'editTransaction'])->name('transactions.edit');
            Route::put('/transactions/{id}', [DashboardController::class, 'updateTransaction'])->name('transactions.update');
            Route::delete('/transactions/{id}', [DashboardController::class, 'destroyTransaction'])->name('transactions.destroy');
        });

        // 🌟 ZONA KHUSUS SUPERADMIN (Organizer/HIMA dilarang masuk)
        Route::middleware(['role:superadmin'])->group(function () {
            
            // Data Master
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::resource('partners', PartnerController::class);
            
            // Kelola Pendaftaran Organizer / HIMA
            Route::get('/organizers', [OrganizerController::class, 'index'])->name('organizers.index');
            Route::post('/organizers/{id}/approve', [OrganizerController::class, 'approve'])->name('organizers.approve');
            Route::post('/organizers/{id}/reject', [OrganizerController::class, 'reject'])->name('organizers.reject');
            
        });
        
    });