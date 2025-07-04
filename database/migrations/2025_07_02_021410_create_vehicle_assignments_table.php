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
        Schema::create('vehicle_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('project_id')->constrained('projects')->onDelete('cascade');
            $table->date('start_datetime');
            $table->date('end_datetime');
            $table->string('start_odometer');
            $table->string('end_odometer')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_assignments');
    }
};
