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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('contract_num');
            $table->string('job_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('contract_type');
            $table->string('fund_source');
            $table->decimal('contract_value', 15, 2);
            $table->decimal('total_budget', 15, 2);
            $table->enum('status', ['On-Progress', 'Completed', 'Cancelled', 'Pending'])->default('Pending');
            $table->unsignedBigInteger('job_id')->nullable();
            $table->foreign('job_id')->references('id')->on('job_types')->onDelete('set null');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreignId('project_manager_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
