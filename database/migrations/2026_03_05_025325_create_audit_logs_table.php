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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('npm')->index();
            $table->string('target_paslon_id');
            $table->string('jenis_vote');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('status')->default('pending_queue'); // pending_queue, processing, success, failed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
