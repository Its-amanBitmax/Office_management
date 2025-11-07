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
        Schema::create('evaluation_overalls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('evaluation_reports')->onDelete('cascade');

            // Sliders from Image
            $table->integer('technical_skills')->default(0);        // 0–40
            $table->integer('task_delivery')->default(0);           // 0–25
            $table->integer('quality_work')->default(0);            // 0–15
            $table->integer('communication')->default(0);           // 0–10
            $table->integer('behavior_teamwork')->default(0);       // 0–10

            // Auto-calculated
            $table->integer('overall_rating')->default(0);          // Sum = 100

            // Dropdown
            $table->enum('performance_grade', [
                'Excellent', 'Good', 'Satisfactory', 'Needs Improvement'
            ])->nullable();

            // Final Feedback
            $table->text('final_feedback')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_overalls');
    }
};
