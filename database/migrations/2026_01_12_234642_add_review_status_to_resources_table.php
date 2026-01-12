<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->string('review_status')->default('pending')->after('access_token');
            $table->text('rejection_notes')->nullable()->after('review_status');
            $table->timestamp('reviewed_at')->nullable()->after('rejection_notes');
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('reviewed_at');

            // Optional FK (only if you want)
            // $table->foreign('reviewed_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            // Optional FK drop if you added it
            // $table->dropForeign(['reviewed_by']);

            $table->dropColumn(['review_status', 'rejection_notes', 'reviewed_at', 'reviewed_by']);
        });
    }
};
