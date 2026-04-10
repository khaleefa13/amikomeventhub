<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Muhammad Dihya Khalifa 24.12.3272';
});

Route::get('/tentang', function () {
return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
});