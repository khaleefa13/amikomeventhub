<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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