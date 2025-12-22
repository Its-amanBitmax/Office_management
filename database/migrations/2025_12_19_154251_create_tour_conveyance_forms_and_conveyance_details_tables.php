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
        // Main Form Table
        Schema::create('tour_conveyance_forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_code', 50)->unique(); // e.g. BMG-TCF-0001
            $table->string('company_name');
            $table->text('company_address')->nullable();
            $table->string('company_logo_path')->nullable(); // Path to logo
            $table->string('form_heading');
            $table->string('form_subheading');
            $table->date('form_date');

            // Employee Details
            $table->string('employee_name');
            $table->string('employee_id');
            $table->string('designation');
            $table->string('department');
            $table->string('reporting_manager');
            $table->string('cost_center');

            // Tour Details
            $table->text('purpose');
            $table->string('tour_location');
            $table->string('project_code')->nullable();
            $table->date('tour_from');
            $table->date('tour_to');

            // Financials
            $table->decimal('advance_taken', 12, 2)->default(0.00);
            $table->decimal('total_expense', 12, 2)->default(0.00);
            $table->decimal('balance_payable', 12, 2)->default(0.00);
            $table->decimal('balance_receivable', 12, 2)->default(0.00);

            // Approvals
            $table->text('manager_remarks')->nullable();
            $table->string('status')->default('Pending'); // Pending, Approved, Rejected

            // Footer
            $table->string('footer_heading');
            $table->string('footer_subheading');

            $table->timestamps();
        });

        // Conveyance Details Table (Child Table)
        Schema::create('conveyance_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_conveyance_form_id')
                  ->constrained('tour_conveyance_forms')
                  ->onDelete('cascade');

            $table->date('travel_date');
            $table->string('mode', 50); // Flight, Train, Taxi, Hotel, Visa, Other
            $table->string('from_location')->nullable();
            $table->string('to_location')->nullable();
            $table->decimal('distance', 10, 2)->default(0.00);
            $table->decimal('amount', 12, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conveyance_details');
        Schema::dropIfExists('tour_conveyance_forms');
    }
};