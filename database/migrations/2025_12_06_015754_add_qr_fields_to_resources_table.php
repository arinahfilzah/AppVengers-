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
    Schema::table('resources', function (Blueprint $table) {
        if (!Schema::hasColumn('resources', 'qr_code_path')) {
            $table->string('qr_code_path')->nullable();
        }

        if (!Schema::hasColumn('resources', 'access_token')) {
            $table->string('access_token')->nullable()->unique();
        }
    });
}

public function down()
{
    Schema::table('resources', function (Blueprint $table) {
        if (Schema::hasColumn('resources', 'qr_code_path')) {
            $table->dropColumn('qr_code_path');
        }

        if (Schema::hasColumn('resources', 'access_token')) {
            $table->dropColumn('access_token');
        }
    });
}

};