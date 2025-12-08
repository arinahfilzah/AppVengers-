<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('session_timeout')->default(30)->after('last_login');
            $table->string('recovery_email')->nullable()->after('session_timeout');
            $table->string('recovery_phone')->nullable()->after('recovery_email');
            $table->boolean('security_notifications')->default(true)->after('recovery_phone');
            $table->json('trusted_devices')->nullable()->after('security_notifications');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'session_timeout',
                'recovery_email',
                'recovery_phone',
                'security_notifications',
                'trusted_devices'
            ]);
        });
    }    
};
