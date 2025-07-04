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
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('tool_code')->unique();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->date('purchase_date')->nullable();
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->enum('condition', ['Baik', 'Perlu Perbaikan', 'Rusak'])->default('Baik');
            $table->date('warranty_period')->nullable();
            $table->string('picture_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
