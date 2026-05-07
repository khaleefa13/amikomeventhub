<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'poster', 'nama_event', 'kategori', 'tanggal', 'harga', 'stok_terjual', 'total_stok'
    ];
}
