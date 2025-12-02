<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {

            // Attendance marking details
            $table->time('marked_time')->nullable()->after('date');
            $table->string('ip_address', 45)->nullable()->after('marked_time');
            $table->string('image')->nullable()->after('ip_address');

            // Sirf ye chahiye: kisne mark kiya (Admin / Employee)
            $table->enum('marked_by_type', ['Employee', 'Admin'])
                  ->nullable()
                  ->after('status'); // ya jahan tumhe sahi lage
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'marked_time',
                'ip_address',
                'image',
                'marked_by_type',
            ]);
        });
    }
};
