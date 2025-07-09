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
        Schema::create('daily_project_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->enum('weather', ['Cerah', 'Berawan', 'Hujan'])->nullable();
            $table->integer('personnel_count');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_project_reports');
    }
};
