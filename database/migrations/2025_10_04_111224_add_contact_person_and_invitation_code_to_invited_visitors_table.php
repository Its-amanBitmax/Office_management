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
        Schema::table('invited_visitors', function (Blueprint $table) {
            $table->string('first_contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('invitation_code')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invited_visitors', function (Blueprint $table) {
            $table->dropColumn(['first_contact_person_name', 'contact_person_phone', 'invitation_code']);
        });
    }
};
