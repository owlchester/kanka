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
        if (! config('logging.enabled')) {
            return;
        }
        if (!Schema::connection('logs')->hasTable('user_logs')) {
            return;
        }
        Schema::connection('logs')->table('user_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! config('logging.enabled')) {
            return;
        }
        if (!Schema::connection('logs')->hasTable('user_logs')) {
            return;
        }
        Schema::connection('logs')->table('user_logs', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->dropColumn('campaign_id');
        });
    }
};
