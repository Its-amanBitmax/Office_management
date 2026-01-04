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
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'mark_in')) {
                $table->time('mark_in')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'mark_out')) {
                $table->time('mark_out')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'break_start')) {
                $table->time('break_start')->nullable();
            }
            if (!Schema::hasColumn('attendances', 'break_time')) {
                $table->time('break_time')->nullable(); // Total break duration
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'mark_in',
                'mark_out',
                'break_start',
                'break_time',
            ]);
        });
    }
};
