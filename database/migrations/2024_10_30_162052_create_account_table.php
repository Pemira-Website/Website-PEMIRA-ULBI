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
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key auto-increment
            $table->string('nama');
            $table->string('npm')->unique();
            $table->string('password'); // password hash akan disimpan
            $table->string('prodi'); // program studi
            $table->boolean('sudah_login')->default(false); // status login
            $table->integer('total_vote')->default(0); // jumlah vote, default 0
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
