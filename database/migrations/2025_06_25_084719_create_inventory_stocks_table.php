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
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('materials')->cascadeOnDelete();
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->decimal('min_stock', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['warehouse_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};
