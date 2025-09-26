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
        Schema::create('expense_budget_history', function (Blueprint $table) {
            $table->id();
            $table->enum('action', ['add', 'update']);
            $table->decimal('amount', 10, 2);
            $table->decimal('old_budget', 10, 2);
            $table->decimal('new_budget', 10, 2);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_budget_history');
    }
};
