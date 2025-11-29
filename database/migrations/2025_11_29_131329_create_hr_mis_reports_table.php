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
        Schema::create('hr_mis_reports', function (Blueprint $table) {
            $table->id();
            $table->enum('report_type', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->date('report_date')->nullable();
            $table->date('week_start')->nullable();
            $table->date('week_end')->nullable();
            $table->string('report_month', 7)->nullable(); // YYYY-MM
            $table->string('department', 100)->default('Human Resources');
            $table->string('center_branch', 100)->nullable();

            // 1. Employee Strength
            $table->integer('total_employees')->default(0);
            $table->integer('new_joiners')->default(0);
            $table->integer('resignations')->default(0);
            $table->integer('absconding')->default(0);
            $table->integer('terminated')->default(0);
            $table->integer('net_strength')->default(0);

            // 2. Attendance Summary
            $table->integer('present_days')->default(0);
            $table->integer('absent_days')->default(0);
            $table->integer('leaves_approved')->default(0);
            $table->integer('half_days')->default(0);
            $table->integer('holiday_days')->default(0);

            // 3. Recruitment Summary
            $table->integer('requirements_raised')->default(0);
            $table->integer('positions_closed')->default(0);
            $table->integer('positions_pending')->default(0);
            $table->integer('interviews_conducted')->default(0);
            $table->integer('selected')->default(0);
            $table->integer('rejected')->default(0);

            // 4. Payroll & Compliance
            $table->boolean('salary_processed')->default(false);
            $table->date('salary_disbursed_date')->nullable();
            $table->text('deductions')->nullable();
            $table->text('pending_compliance')->nullable();

            // 5. Employee Relations
            $table->integer('grievances_received')->default(0);
            $table->integer('grievances_resolved')->default(0);
            $table->integer('warning_notices')->default(0);
            $table->integer('appreciations')->default(0);

            // 6. Training
            $table->integer('trainings_conducted')->default(0);
            $table->integer('employees_attended')->default(0);
            $table->text('training_feedback')->nullable();

            // 7. HR Activities
            $table->text('birthday_celebrations')->nullable();
            $table->text('engagement_activities')->nullable();
            $table->text('hr_initiatives')->nullable();
            $table->text('special_events')->nullable();

            $table->text('notes')->nullable();
            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_mis_reports');
    }
};
