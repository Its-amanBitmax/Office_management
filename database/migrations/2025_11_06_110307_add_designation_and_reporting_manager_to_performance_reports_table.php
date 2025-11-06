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
        Schema::table('performance_reports', function (Blueprint $table) {
            $table->string('designation', 100)->nullable()->after('employee_id');
            $table->string('reporting_manager', 255)->nullable()->after('designation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('performance_reports', function (Blueprint $table) {
            $table->dropColumn(['designation', 'reporting_manager']);
        });
    }
};
