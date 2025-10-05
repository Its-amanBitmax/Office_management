<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Enum me 'Holiday' add kar rahe hain
            $table->enum('status', ['Present', 'Absent', 'Leave', 'Half Day', 'Holiday'])
                  ->default('Present')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Agar rollback ho to 'Holiday' hata denge
            $table->enum('status', ['Present', 'Absent', 'Leave', 'Half Day'])
                  ->default('Present')
                  ->change();
        });
    }
};
