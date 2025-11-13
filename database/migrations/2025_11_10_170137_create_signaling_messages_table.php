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
        Schema::create('signaling_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained()->onDelete('cascade');
            $table->string('type'); // offer, answer, ice-candidate
            $table->longText('sdp')->nullable(); // Raw SDP text for offers/answers (can be > 7000 chars) - DO NOT MODIFY
            $table->json('ice_candidate')->nullable(); // ICE candidate data
            $table->text('text')->nullable(); // Question text
            $table->integer('question_id')->nullable(); // Question ID
            $table->string('sender_type'); // interviewer, candidate
            $table->string('target_type')->nullable(); // interviewer, candidate (null for broadcast)
            $table->boolean('delivered')->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index(['interview_id', 'type']);
            $table->index(['interview_id', 'delivered']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signaling_messages');
    }
};
