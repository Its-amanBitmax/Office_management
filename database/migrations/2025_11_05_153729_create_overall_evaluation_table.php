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
        Schema::create('overall_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->integer('technical_skills_score')->nullable();
            $table->integer('task_delivery_score')->nullable();
            $table->integer('quality_of_work_score')->nullable();
            $table->integer('communication_score')->nullable();
            $table->integer('teamwork_score')->nullable();
            $table->integer('overall_rating')->nullable();
            $table->enum('performance_grade', ['Excellent', 'Good', 'Satisfactory', 'Needs Improvement'])->nullable();
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('performance_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overall_evaluation');
    }
};
