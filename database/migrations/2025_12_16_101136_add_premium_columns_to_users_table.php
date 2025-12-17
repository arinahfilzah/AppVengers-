<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('account_type', ['basic', 'premium', 'contributor'])
                  ->default('basic')
                  ->after('email');
            $table->dateTime('premium_expires_at')->nullable()->after('account_type');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['account_type', 'premium_expires_at']);
        });
    }
};