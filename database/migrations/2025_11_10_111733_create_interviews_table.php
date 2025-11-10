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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique_id');
            $table->string('candidate_name');
            $table->string('candidate_email')->unique();
            $table->string('candidate_phone', 15)->nullable();
            $table->string('candidate_resume_path')->nullable();
            $table->date('date');
            $table->time('time');
            $table->dateTime('scheduled_at')->useCurrent();
            $table->uuid('unique_link')->unique();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'rescheduled'])
                  ->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
