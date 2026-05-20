<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::firstOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name' => 'Admin Super',
                'password' => Hash::make('admin123'), 
                'role' => 'admin',
            ]
        );

        // ==========================================
        // 2. Insert Sampel Events (SUDAH DISESUAIKAN 100% DENGAN DATABASE ANDA)
        // Kolom deskripsi & lokasi dihapus karena tidak ada di tabel.
        // Kolom stok_terjual ditambahkan sesuai struktur Anda.
        // ==========================================
        
        Event::create([
            'kategori' => 'Entertainment',
            'nama_event' => 'Jazz Night 2025',
            'tanggal' => '2026-05-10',
            'harga' => 50000, 
            'stok_terjual' => 0,
            'total_stok' => 100,
            'poster' => 'posters/event-1.png',
        ]);

        Event::create([
            'kategori' => 'Seminar',
            'nama_event' => 'Hackaton - Unleash Your Inner Developer',
            'tanggal' => '2026-05-05',
            'harga' => 50000,
            'stok_terjual' => 0,
            'total_stok' => 100,
            'poster' => 'posters/event-2.png',
        ]);

        Event::create([
            'kategori' => 'Tech',
            'nama_event' => 'AI & FUTURE TECH SUMMIT 2026',
            'tanggal' => '2026-05-01',
            'harga' => 50000,
            'stok_terjual' => 0,
            'total_stok' => 100,
            'poster' => 'posters/event-3.png',
        ]);

        Event::create([
            'kategori' => 'Workshop',
            'nama_event' => 'UI/UX Masterclass: Designing for Tomorrow',
            'tanggal' => '2026-06-15',
            'harga' => 75000,
            'stok_terjual' => 0,
            'total_stok' => 50,
            'poster' => 'posters/event-4.png',
        ]);

        Event::create([
            'kategori' => 'Tech',
            'nama_event' => 'E-Sport U-Champ: Mobile Legends Tournament',
            'tanggal' => '2026-07-20',
            'harga' => 100000, 
            'stok_terjual' => 0,
            'total_stok' => 32, 
            'poster' => 'posters/event-5.png',
        ]);

        Event::create([
            'kategori' => 'Entertainment',
            'nama_event' => 'Stand Up Comedy Campus Tour',
            'tanggal' => '2026-08-05',
            'harga' => 60000,
            'stok_terjual' => 0,
            'total_stok' => 200,
            'poster' => 'posters/event-6.png',
        ]);
    }
}