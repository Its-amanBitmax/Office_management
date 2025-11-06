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
        Schema::create('soft_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->tinyInteger('professionalism')->nullable();
            $table->tinyInteger('team_collaboration')->nullable();
            $table->tinyInteger('learning_adaptability')->nullable();
            $table->tinyInteger('initiative_ownership')->nullable();
            $table->tinyInteger('time_management')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('performance_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soft_skills');
    }
};
