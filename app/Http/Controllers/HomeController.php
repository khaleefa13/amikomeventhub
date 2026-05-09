<?php

namespace App\Http\Controllers;

use App\Models\Event; // Pastikan Model Event dipanggil di atas
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil semua data event dari database (yang terbaru di atas)
        $events = Event::latest()->get(); 
        
        // Membuka file welcome.blade.php sambil membawa data $events
        return view('welcome', compact('events')); 
    }
}