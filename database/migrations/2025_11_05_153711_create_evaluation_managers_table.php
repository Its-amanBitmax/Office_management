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
        Schema::create('evaluation_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('evaluation_reports')->onDelete('cascade');

            // Technical KPIs (Text Feedback)
            $table->text('project_delivery')->nullable();
            $table->text('code_quality')->nullable();
            $table->text('performance')->nullable();
            $table->text('task_completion')->nullable();
            $table->text('innovation')->nullable();

            // Star Ratings (1–5)
            $table->integer('code_efficiency')->nullable();     // 1-5
            $table->integer('uiux')->nullable();
            $table->integer('debugging')->nullable();
            $table->integer('version_control')->nullable();
            $table->integer('documentation')->nullable();

            // Auto Score
            $table->integer('manager_total')->default(0); // Out of 60

            // Comments
            $table->text('manager_comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_managers');
    }
};
