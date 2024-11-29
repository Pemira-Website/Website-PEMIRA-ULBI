<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_suara', function (Blueprint $table) {
            $table->bigIncrements('id');                // ID Hasil Suara
            $table->unsignedBigInteger('pemilu_id');    // ID Pemilu (FK dari tabel pemilu)
            $table->unsignedBigInteger('kandidat_id');  // ID Kandidat (FK dari tabel kandidat)
            $table->integer('jumlah_suara')->default(0); // Jumlah suara yang diterima
            $table->timestamps();                       // Timestamps untuk created_at dan updated_at

            $table->foreign('pemilu_id')->references('id')->on('pemilu')->onDelete('cascade');
            $table->foreign('kandidat_id')->references('id')->on('kandidat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_suara');
    }
};
