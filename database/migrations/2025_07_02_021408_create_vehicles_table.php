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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('vehicle_type', ['Mobil', 'Truk', 'Alat Berat']);
            $table->string('merk');
            $table->string('model');
            $table->string('license_plate')->unique();
            $table->year('purchase_year');
            $table->string('capacity');
            $table->string('vehicle_license')->unique();
            $table->date('license_expiry_date');
            $table->string('vehicle_identity_number')->unique();
            $table->string('engine_number')->unique();
            $table->date('tax_due_date');
            $table->text('notes')->nullable();
            $table->string('docs_path')->nullable();
            $table->foreignId('pic_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
