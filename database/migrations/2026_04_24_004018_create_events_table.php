<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('poster')->nullable(); // Untuk menyimpan path gambar
            $table->string('nama_event');
            $table->string('kategori');
            $table->date('tanggal');
            $table->integer('harga');
            $table->integer('stok_terjual')->default(0);
            $table->integer('total_stok');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};