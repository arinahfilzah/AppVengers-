<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   

    public function up(): void
{
    Schema::table('resources', function (Blueprint $table) {
        if (!Schema::hasColumn('resources', 'qr_code_path')) {
            $table->string('qr_code_path')->nullable()->after('file_path');
        }

        if (!Schema::hasColumn('resources', 'access_token')) {
            $table->string('access_token', 32)->unique()->nullable()->after('qr_code_path');
        }
    });
}


    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['qr_code_path', 'access_token']);
        });
    }
};