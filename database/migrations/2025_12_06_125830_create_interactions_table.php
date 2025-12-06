<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('interactions', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('lead_id'); // lead reference
        $table->enum('activity_type', [
            'call',
            'whatsapp',
            'email',
            'meeting',
            'follow_up',
            'note',
            'proposal'
        ]);

        $table->string('subject')->nullable();
        $table->text('description')->nullable();

        $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
        $table->dateTime('activity_date')->nullable();
        $table->date('next_follow_up')->nullable();

        $table->unsignedBigInteger('created_by')->nullable(); // user / BD executive

        $table->timestamps();

        // (Optional but recommended)
        // $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
    });
}

};

