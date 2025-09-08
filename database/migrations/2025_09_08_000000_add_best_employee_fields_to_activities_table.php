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
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('best_employee_id')->nullable()->after('scoring_scope');
            $table->text('best_employee_description')->nullable()->after('best_employee_id');
            $table->boolean('keep_best_employee')->default(false)->after('best_employee_description');

            $table->foreign('best_employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['best_employee_id']);
            $table->dropColumn(['best_employee_id', 'best_employee_description', 'keep_best_employee']);
        });
    }
};
