<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!env('DB_LOGS_DATABASE', false)) {
            return;
        }
        Schema::connection('logs')->table('user_logs', function (Blueprint $table) {
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!env('DB_LOGS_DATABASE', false)) {
            return;
        }
        Schema::table('user_logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
};
