<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasPresmaStatus = Schema::hasColumn('pemilih', 'presma_status');
        $hasHimaStatus = Schema::hasColumn('pemilih', 'hima_status');

        Schema::table('pemilih', function (Blueprint $table) use ($hasPresmaStatus, $hasHimaStatus) {
            if (!$hasPresmaStatus) {
                $table->string('presma_status')->default('not_voted')->after('pml_presma');
            }

            if (!$hasHimaStatus) {
                $table->string('hima_status')->default('not_voted')->after('pml_hima');
            }
        });

        DB::table('pemilih')->update([
            'presma_status' => DB::raw("CASE WHEN pml_presma = 1 THEN 'completed' ELSE 'not_voted' END"),
            'hima_status' => DB::raw("CASE WHEN pml_hima = 1 THEN 'completed' ELSE 'not_voted' END"),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hasPresmaStatus = Schema::hasColumn('pemilih', 'presma_status');
        $hasHimaStatus = Schema::hasColumn('pemilih', 'hima_status');

        Schema::table('pemilih', function (Blueprint $table) use ($hasPresmaStatus, $hasHimaStatus) {
            if ($hasPresmaStatus) {
                $table->dropColumn('presma_status');
            }

            if ($hasHimaStatus) {
                $table->dropColumn('hima_status');
            }
        });
    }
};
