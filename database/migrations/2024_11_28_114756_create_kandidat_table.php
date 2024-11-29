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
        Schema::create('kandidat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pemilu_id');  // Foreign Key ke tabel pemilu
            $table->string('nama');
            $table->string('npm')->unique();
            $table->string('prodi');
            $table->string('angkatan');
            $table->enum('jenis', ['presma', 'wakil_presma', 'kahim', 'wakil_kahim']);
            $table->string('no_paslon');
            $table->text('visi');
            $table->text('misi');
            $table->string('foto');
            $table->unsignedBigInteger('himpunan_id')->nullable();  // Foreign Key ke tabel himpunan (optional)
            $table->timestamps();
        
            // Foreign Keys
            $table->foreign('pemilu_id')->references('id')->on('pemilu')->onDelete('cascade');
            $table->foreign('himpunan_id')->references('id')->on('himpunan')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidat');
    }
};
