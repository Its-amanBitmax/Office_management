<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('interviews', function (Blueprint $table) {
        $table->enum('link_status', ['0', '1'])
              ->default('0')
              ->comment('0 = Inactive, 1 = Active')
              ->after('candidate_resume_path'); // optional
    });
}

public function down()
{
    Schema::table('interviews', function (Blueprint $table) {
        $table->dropColumn('link_status');
    });
}

};
