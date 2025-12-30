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
        Schema::create('resource_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained()->onDelete('cascade');
            $table->integer('version_number');
            $table->string('file_path');
            $table->text('change_notes')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamp('created_at');
            
            $table->index(['resource_id', 'version_number']);
        });

        // Add current_version column to resources table
        Schema::table('resources', function (Blueprint $table) {
            $table->integer('current_version')->default(1)->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_versions');
        
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('current_version');
        });
    }
};