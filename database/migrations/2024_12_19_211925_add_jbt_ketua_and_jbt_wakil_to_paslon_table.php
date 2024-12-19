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
        Schema::table('paslon', function (Blueprint $table) {
            $table->string('jbt_ketua')->nullable()->after('ang_ketua'); // Menambahkan kolom jbt_ketua
            $table->string('jbt_wakil')->nullable()->after('ang_wakil'); // Menambahkan kolom jbt_wakil
        });
    }
    
    public function down()
    {
        Schema::table('paslon', function (Blueprint $table) {
            $table->dropColumn('jbt_ketua'); // Menghapus kolom jbt_ketua jika rollback
            $table->dropColumn('jbt_wakil'); // Menghapus kolom jbt_wakil jika rollback
        });
    }
    
};
