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
        Schema::table('stock_movements', function (Blueprint $table) {
            // Kita ubah kedua kolom agar boleh NULL
            $table->string('movable_type')->nullable()->change();
            $table->unsignedBigInteger('movable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            // Kode untuk mengembalikan jika diperlukan
            $table->string('movable_type')->nullable(false)->change();
            $table->unsignedBigInteger('movable_id')->nullable(false)->change();
        });
    }
};
