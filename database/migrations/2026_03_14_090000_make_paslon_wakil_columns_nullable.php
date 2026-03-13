<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paslon', function (Blueprint $table) {
            $table->string('nm_wakil')->nullable()->change();
            $table->integer('npm_wakil')->nullable()->change();
            $table->string('pd_wakil')->nullable()->change();
            $table->string('ang_wakil')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('paslon', function (Blueprint $table) {
            $table->string('nm_wakil')->nullable(false)->default('')->change();
            $table->integer('npm_wakil')->nullable(false)->default(0)->change();
            $table->string('pd_wakil')->nullable(false)->default('')->change();
            $table->string('ang_wakil')->nullable(false)->default('')->change();
        });
    }
};
