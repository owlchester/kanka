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
        Schema::table('campaign_imports', function (Blueprint $table) {
            $table->text('logs')->nullable();
            $table->text('errors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaign_imports', function (Blueprint $table) {
            $table->dropColumn('logs');
            $table->dropColumn('errors');
        });
    }
};
