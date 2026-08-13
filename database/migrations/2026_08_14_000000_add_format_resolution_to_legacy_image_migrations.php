<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('legacy_image_migrations', function (Blueprint $table) {
            $table->string('destination_path')->nullable()->change();
            $table->string('detected_mime', 100)->nullable()->after('destination_path');
            $table->string('source_content_type', 100)->nullable()->after('detected_mime');
            $table->string('resolution_status', 20)->default('pending')->after('source_content_type');
            $table->timestamp('resolved_at')->nullable()->after('resolution_status');
        });
    }

    public function down(): void
    {
        Schema::table('legacy_image_migrations', function (Blueprint $table) {
            $table->dropColumn([
                'detected_mime',
                'source_content_type',
                'resolution_status',
                'resolved_at',
            ]);
            $table->string('destination_path')->nullable(false)->change();
        });
    }
};
