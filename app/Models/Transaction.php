<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // 1. TAMBAHKAN INI: Memberi izin kolom mana saja yang boleh diisi data
    protected $fillable = [
        'event_id',
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'status',
        'snap_token',
    ];

    // 2. PASTIKAN INI ADA: Relasi balik ke tabel events (Sangat penting untuk Dashboard Admin)
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}