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
        Schema::create('performance_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('review_from');
            $table->date('review_to');
            $table->date('evaluation_date');

            $table->text('project_delivery')->nullable();
            $table->text('code_quality')->nullable();
            $table->text('system_performance')->nullable();
            $table->text('task_completion')->nullable();
            $table->text('innovation')->nullable();
            $table->text('teamwork')->nullable();
            $table->text('communication')->nullable();
            $table->text('attendance')->nullable();

            $table->text('manager_feedback')->nullable();
            $table->text('employee_comments')->nullable();

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reports');
    }
};
