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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code', 50)->unique();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->date('hire_date');
            $table->string('position', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('status', 50)->default('active');
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
