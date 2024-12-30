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
        Schema::table('pemilih', function (Blueprint $table) {
            $table->integer('pml_presma')->default(0);
            $table->integer('pml_hima')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemilih', function (Blueprint $table) {
            $table->dropColumn(['pml_presma', 'pml_hima']);
        });
    }
};
