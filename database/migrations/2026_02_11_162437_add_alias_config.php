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
        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('aliases')->default(true);
            $table->renameColumn('assets', 'media');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('aliases');
            $table->renameColumn('media', 'assets');
        });
    }
};
