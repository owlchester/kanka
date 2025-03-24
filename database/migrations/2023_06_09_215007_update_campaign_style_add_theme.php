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
        Schema::table('campaign_styles', function (Blueprint $table) {
            $table->boolean('is_theme')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_styles', function (Blueprint $table) {
            $table->dropColumn('is_theme');
        });
    }
};
