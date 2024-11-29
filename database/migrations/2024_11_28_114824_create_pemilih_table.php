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
        Schema::create('pemilih', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID pemilih
            $table->string('Nama'); // Nama lengkap pemilih
            $table->string('Nim')->unique(); // NIM pemilih (unique)
            $table->string('Program Studi'); // Program studi pemilih
            $table->string('password'); // Password untuk login
            $table->boolean('status_voting')->default(false); // Status voting, false = belum memilih, true = sudah memilih
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilih');
    }
};
