<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('category_statuses', function (Blueprint $table) {
            $table->index('category_id');
        });

        Schema::table('category_statuses', function (Blueprint $table) {
            $table->unsignedInteger('campaign_id')->nullable();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->dropUnique(['category_id', 'key']);
            $table->unique(
                ['campaign_id', 'category_id', 'key'],
                'category_statuses_campaign_category_key_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('category_statuses')->whereNotNull('campaign_id')->delete();

        Schema::table('category_statuses', function (Blueprint $table) {
            $table->dropUnique('category_statuses_campaign_category_key_unique');
            $table->dropForeign(['campaign_id']);
            $table->dropColumn('campaign_id');
            $table->unique(['category_id', 'key']);
        });

        Schema::table('category_statuses', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
        });
    }
};
