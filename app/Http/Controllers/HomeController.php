<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Tambahkan Request $request di dalam parameter
    public function index(Request $request) 
    {
        $partners = Partner::latest()->get();

        // 1. Memulai query builder untuk Event
        $query = Event::query();

        // 2. Cek apakah ada request filter 'category' yang diklik user
        if ($request->has('category') && $request->category != '') {
            $query->where('kategori', $request->category);
        }

        // 3. Ambil data setelah difilter (atau semua data jika tidak ada filter)
        $events = $query->latest()->get();

        $categories = [
            'Musik', 
            'Tech', 
            'Workshop', 
            'Seminar', 
            'Olahraga', 
            'Seni'
        ];

        return view('welcome', compact('partners', 'categories', 'events'));
    }
}