<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // 🌟 PERBAIKAN: Menambahkan 'user_id' agar HIMA bisa mengklaim kepemilikan event-nya
    protected $fillable = [
        'user_id',
        'poster', 
        'nama_event', 
        'kategori', 
        'tanggal', 
        'harga', 
        'stok_terjual', 
        'total_stok'
    ];

    // Relasi: Event memiliki banyak ulasan
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relasi: Event ini milik siapa? (Superadmin atau Organizer/HIMA)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}