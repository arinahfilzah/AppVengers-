<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('users', 'is_premium')) {
                $table->boolean('is_premium')->default(false)->after('account_status');
            }
            if (!Schema::hasColumn('users', 'premium_expiry')) {
                $table->timestamp('premium_expiry')->nullable()->after('is_premium');
            }
            if (!Schema::hasColumn('users', 'premium_plan_id')) {
                $table->foreignId('premium_plan_id')->nullable()->constrained('premium_plans')->onDelete('set null')->after('premium_expiry');
            }
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->enum('account_type', ['basic', 'premium'])->default('basic')->after('premium_plan_id');
            }
            if (!Schema::hasColumn('users', 'wallet_balance')) {
                $table->decimal('wallet_balance', 10, 2)->default(1000.00)->after('account_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['premium_plan_id']);
            $table->dropColumn(['is_premium', 'premium_expiry', 'premium_plan_id', 'account_type', 'wallet_balance']);
        });
    }
};