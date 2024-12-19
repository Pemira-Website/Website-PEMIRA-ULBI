<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoColumnsToPaslonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paslon', function (Blueprint $table) {
            $table->string('ft_ketua')->nullable()->after('nm_wakil'); // Menambahkan kolom foto_ketua
            $table->string('ft_wakil')->nullable()->after('ft_ketua'); // Menambahkan kolom foto_wakil
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paslon', function (Blueprint $table) {
            $table->dropColumn('ft_ketua');
            $table->dropColumn('ft_wakil');
        });
    }
}
