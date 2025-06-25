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
        Schema::create('work_item_labors', function (Blueprint $table) {
            $table->id();
            $table->string('labor_type');
            $table->decimal('quantity', 10, 2);
            $table->decimal('rate', 15, 2);
            $table->unsignedBigInteger('work_item_id')->nullable();
            $table->foreign('work_item_id')->references('id')->on('project_work_items')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_item_labors');
    }
};
