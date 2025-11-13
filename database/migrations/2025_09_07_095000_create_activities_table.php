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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'active', 'completed'])->default('pending');
            $table->dateTime('schedule_at')->nullable();
            $table->timestamps();
        });

        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('from_employee_id');
            $table->unsignedBigInteger('to_employee_id');
            $table->unsignedBigInteger('criteria_id');
            $table->integer('points');
            $table->timestamps();

            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('from_employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('to_employee_id')->references('id')->on('employees')->onDelete('cascade');
            // Assuming criteria_id references a criteria table, add foreign key if exists
            // $table->foreign('criteria_id')->references('id')->on('criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
        Schema::dropIfExists('activities');
    }
};
