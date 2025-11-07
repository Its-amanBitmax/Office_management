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
        Schema::create('evaluation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('review_from');
            $table->date('review_to');
            $table->date('evaluation_date')->nullable();

            // Submission Flags
            $table->boolean('manager_submitted')->default(false);
            $table->boolean('hr_submitted')->default(false);
            $table->boolean('overall_submitted')->default(false);

            // Submitted By
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->unsignedBigInteger('hr_id')->nullable();
            $table->unsignedBigInteger('final_approver_id')->nullable();

            // Final Score
            $table->decimal('overall_score', 5, 2)->nullable(); // e.g., 87.50
            $table->string('performance_grade')->nullable();   // Excellent, Good, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_reports');
    }
};
