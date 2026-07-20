<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        // Relasi ke event yang di-review
        $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
        // Relasi ke tiket spesifik agar 1 tiket = 1 review
        $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
        // Nilai bintang (1-5)
        $table->tinyInteger('rating'); 
        // Komentar
        $table->text('comment');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
