<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneCompanyToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('admins', 'company_name')) {
                $table->string('company_name')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('admins', 'company_logo')) {
                $table->string('company_logo')->nullable()->after('company_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('admins', 'company_name')) {
                $table->dropColumn('company_name');
            }
            if (Schema::hasColumn('admins', 'company_logo')) {
                $table->dropColumn('company_logo');
            }
        });
    }
}
