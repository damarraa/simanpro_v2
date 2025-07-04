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
        Schema::create('asset_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('tools')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('assigned_date');
            $table->date('returned_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_assignments');
    }
};
