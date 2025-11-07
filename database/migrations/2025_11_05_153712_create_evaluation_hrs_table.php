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
        Schema::create('evaluation_hrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('evaluation_reports')->onDelete('cascade');

            // Soft Skills (Text)
            $table->text('teamwork')->nullable();
            $table->text('communication')->nullable();
            $table->text('attendance')->nullable();

            // Star Ratings (1–5)
            $table->integer('professionalism')->nullable();
            $table->integer('team_collaboration')->nullable();
            $table->integer('learning')->nullable();
            $table->integer('initiative')->nullable();
            $table->integer('time_management')->nullable();

            // Auto Score
            $table->integer('hr_total')->default(0); // Out of 30

            // Comments
            $table->text('hr_comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_hrs');
    }
};
