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
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->enum('leave_type', ['sick', 'casual', 'annual', 'maternity', 'paternity', 'emergency', 'other'])->nullable()->after('description');
            $table->date('start_date')->nullable()->after('leave_type');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('days')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn(['leave_type', 'start_date', 'end_date', 'days']);
        });
    }
};
