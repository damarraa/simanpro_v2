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
        Schema::create('work_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->date('realization_date');
            $table->decimal('realized_volume', 10, 2);
            $table->text('notes')->nullable();
            $table->string('realization_docs_path')->nullable();
            $table->string('control_docs_path')->nullable();
            $table->unsignedBigInteger('work_item_id')->nullable();
            $table->foreign('work_item_id')->references('id')->on('project_work_items')->onDelete('set null');
            $table->unsignedBigInteger('daily_project_report_id')->nullable();
            $table->foreign('daily_project_report_id')->references('id')->on('daily_project_reports')->onDelete('set null');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps(); // ✅
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_activity_logs');
    }
};
