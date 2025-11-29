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
        Schema::table('hr_mis_reports', function (Blueprint $table) {
            $table->integer('ncns_days')->default(0)->after('holiday_days');
            $table->integer('lwp_days')->default(0)->after('ncns_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hr_mis_reports', function (Blueprint $table) {
            $table->dropColumn(['ncns_days', 'lwp_days']);
        });
    }
};
