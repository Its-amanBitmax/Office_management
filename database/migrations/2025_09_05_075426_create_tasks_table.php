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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name', 255);
            $table->text('description');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->enum('assigned_team', ['Individual', 'Team']);
            $table->json('team_members')->nullable();
            $table->unsignedBigInteger('team_lead_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Not Started', 'In Progress', 'Completed', 'On Hold'])->default('Not Started');
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->decimal('progress', 5, 2)->default(0.00);
            $table->timestamps();
            $table->foreign('assigned_to')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('team_lead_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
