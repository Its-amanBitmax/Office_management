<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->enum('scoring_scope', ['selected', 'all'])
                  ->default('selected')
                  ->after('schedule_at');
        });
    }

    public function down(): void
    {
        // Schema::table('activities', function (Blueprint $table) {
        //     $table->dropColumn('scoring_scope');
        // });
    }
};

