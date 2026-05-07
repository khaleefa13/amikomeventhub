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


// ==========================================
// RUTE USER AREA & HALAMAN STATIS
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', function () { return view('home'); });
Route::get('/tentang', function () { return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>'; });
Route::get('/kontak', function () { return redirect('/'); });
Route::get('/profil', function () { return view('profil'); });
Route::get('/katalog', function () { return view('katalog'); });
Route::get('/bantuan', function () { return view('bantuan'); });

// Fitur Interaksi User
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');


// ==========================================
// RUTE ADMIN AREA
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::resource('events', AdminEventController::class);

});