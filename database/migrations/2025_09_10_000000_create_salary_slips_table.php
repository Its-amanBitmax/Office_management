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
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('month'); // YYYY-MM format
            $table->year('year');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('hra', 10, 2)->default(0);
            $table->decimal('conveyance', 10, 2)->default(0);
            $table->decimal('medical', 10, 2)->default(0);
            $table->integer('total_working_days');
            $table->integer('present_days');
            $table->integer('absent_days');
            $table->integer('leave_days');
            $table->integer('half_day_count');
            $table->decimal('gross_salary', 10, 2);
            $table->json('deductions')->nullable(); // Store deductions as JSON
            $table->decimal('net_salary', 10, 2);
            $table->timestamp('generated_at');
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index(['employee_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_slips');
    }
};
