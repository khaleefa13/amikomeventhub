<?php

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\EventController; 
use App\Http\Controllers\Admin\DashboardController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ('home');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/tentang', function () {
return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
});

Route::get('/kontak', function () {
return view('contact');
});

// Rute untuk Profil
Route::get('/profil', function () {
    return view('profil');
});

// Rute untuk Katalog
Route::get('/katalog', function () {
    return view('katalog');
});

// Rute untuk Bantuan
Route::get('/bantuan', function () {
    return view('bantuan');
});


// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event/1', [EventController::class, 'show'])->name('events.show');

Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');


// Rute Admin Area
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/events', [EventController::class, 'indexAdmin'])->name('events.index');

    // dan seterusnya...

});