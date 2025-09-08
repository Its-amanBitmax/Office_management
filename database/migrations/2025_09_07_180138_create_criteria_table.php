<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('activity_id'); // related activity
            $table->string('name'); // criteria name
            $table->text('description')->nullable(); // criteria detail
            $table->integer('max_points')->default(10); // max points allowed
            $table->timestamps();

            // foreign key relation
            $table->foreign('activity_id')
                  ->references('id')
                  ->on('activities')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('criteria');
    }
};


