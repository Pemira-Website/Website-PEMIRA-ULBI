<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paslon', function (Blueprint $table) {
            $table->id();
            $table->integer('paslon_ke');
            $table->string('nm_ketua'); // Nama Ketua
            $table->string('nm_wakil'); // Nama Wakil
            $table->integer('npm_ketua');
            $table->integer('npm_wakil');
            $table->string('pd_ketua'); // Prodi Ketua
            $table->string('pd_wakil'); // Prodi Wakil
            $table->string('ang_ketua'); // Angkatan Ketua
            $table->string('ang_wakil'); // Angkatan Wakil
            $table->text('visi'); // Visi
            $table->text('misi'); // Misi
            $table->string('jenis_pemilihan'); // Jenis Pemilihan (presma/himatif/etc.)
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('paslon');
    }
};
