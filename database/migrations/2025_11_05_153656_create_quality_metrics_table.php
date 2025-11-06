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
        Schema::create('quality_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->tinyInteger('code_efficiency')->nullable();
            $table->tinyInteger('uiux')->nullable();
            $table->tinyInteger('debugging')->nullable();
            $table->tinyInteger('version_control')->nullable();
            $table->tinyInteger('documentation')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('performance_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_metrics');
    }
};
