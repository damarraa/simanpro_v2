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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->from('vehicles')->constrained()->onDelete('cascade');
            $table->date('maintenance_date');
            $table->integer('odometer');
            $table->enum('type', ['Rutin', 'Insidental', 'Darurat']);
            $table->string('location');
            $table->text('notes')->nullable();
            $table->string('docs_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
