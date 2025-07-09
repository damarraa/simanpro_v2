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
        Schema::table('maintenance_logs', function (Blueprint $table) {
            // Kita tidak perlu drop, langsung tambahkan constraint-nya
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('restrict'); // 'restrict' lebih aman
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_logs', function (Blueprint $table) {
            // Jika di-rollback, cukup hapus foreign key yang kita tambahkan
            $table->dropForeign(['vehicle_id']);
        });
    }
};
