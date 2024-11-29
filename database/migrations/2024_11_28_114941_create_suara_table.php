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
        Schema::create('suara', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pemilih_id'); // Foreign Key ke tabel pemilih
            $table->unsignedBigInteger('presma_id'); // Foreign Key ke tabel kandidat presma
            $table->unsignedBigInteger('kahim_id'); // Foreign Key ke tabel kandidat kahim
            $table->timestamps();

            // Foreign Keys
            $table->foreign('pemilih_id')->references('id')->on('pemilih')->onDelete('cascade');
            $table->foreign('presma_id')->references('id')->on('kandidat')->onDelete('cascade');
            $table->foreign('kahim_id')->references('id')->on('kandidat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suara');
    }
};
