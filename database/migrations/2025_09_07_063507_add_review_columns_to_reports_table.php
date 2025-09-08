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
        Schema::table('reports', function (Blueprint $table) {
            // Admin review fields
            $table->text('admin_review')->nullable();
            $table->integer('admin_rating')->nullable();
            $table->enum('admin_status', ['sent', 'read', 'responded'])->nullable();

            // Team lead review fields
            $table->text('team_lead_review')->nullable();
            $table->integer('team_lead_rating')->nullable();
            $table->enum('team_lead_status', ['sent', 'read', 'responded'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'admin_review',
                'admin_rating',
                'admin_status',
                'team_lead_review',
                'team_lead_rating',
                'team_lead_status'
            ]);
        });
    }
};
