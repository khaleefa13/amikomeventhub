<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama
        User::firstOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name' => 'Admin Amikom',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // ==========================================
        // 2. Insert Kategori Event (Minimal 3 Kategori)
        // ==========================================
        $kategoriSeminar = Category::firstOrCreate(
            ['slug' => 'seminar-it'],
            ['name' => 'Seminar IT']
        );

        $kategoriHiburan = Category::firstOrCreate(
            ['slug' => 'entertainment'],
            ['name' => 'Entertainment']
        );

        // Tambahan Kategori ke-3 sesuai hint tugas
        $kategoriEsport = Category::firstOrCreate(
            ['slug' => 'e-sport'],
            ['name' => 'E-Sport']
        );

        // ==========================================
        // 3. Insert Sampel Events (Minimal 6 Event)
        // ==========================================
        
        // Event 1
        Event::create([
            'category_id' => $kategoriHiburan->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000, 
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        // Event 2
        Event::create([
            'category_id' => $kategoriSeminar->id,
            'title' => 'Hackaton - Unleash Your Inner Developer',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
            'date' => '2026-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        // Event 3
        Event::create([
            'category_id' => $kategoriSeminar->id,
            'title' => 'AI & FUTURE TECH SUMMIT 2026',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);

        // Event 4 (Tambahan sesuai soal)
        Event::create([
            'category_id' => $kategoriSeminar->id,
            'title' => 'UI/UX Masterclass: Designing for Tomorrow',
            'description' => 'Pelajari rahasia membuat desain antarmuka yang intuitif langsung dari para praktisi industri.',
            'date' => '2026-06-15 09:00:00',
            'location' => 'Ruang Citra 1',
            'price' => 75000,
            'stock' => 50,
            'poster_path' => 'posters/event-4.png',
        ]);

        // Event 5 (Tambahan sesuai soal)
        Event::create([
            'category_id' => $kategoriEsport->id,
            'title' => 'E-Sport U-Champ: Mobile Legends Tournament',
            'description' => 'Siapkan tim terbaikmu dan rebut gelar juara di turnamen e-sport kampus terbesar tahun ini!',
            'date' => '2026-07-20 10:00:00',
            'location' => 'Amikom E-Sport Arena',
            'price' => 100000, 
            'stock' => 32, 
            'poster_path' => 'posters/event-5.png',
        ]);

        // Event 6 (Tambahan untuk melengkapi 6 event)
        Event::create([
            'category_id' => $kategoriHiburan->id,
            'title' => 'Stand Up Comedy Campus Tour',
            'description' => 'Malam penuh tawa bersama komika-komika ternama tanah air yang siap mengocok perutmu.',
            'date' => '2026-08-05 19:30:00',
            'location' => 'Auditorium Amikom',
            'price' => 60000,
            'stock' => 200,
            'poster_path' => 'posters/event-6.png',
        ]);
    }
}