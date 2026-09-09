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
        Schema::table('tier_prices', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('stripe_id');
            $table->string('pricing_version', 50)->nullable()->after('is_active');

            $table->unique('stripe_id');
            $table->unique(
                ['pricing_version', 'tier_id', 'currency', 'period'],
                'tier_prices_version_unique'
            );
            $table->index(
                ['tier_id', 'currency', 'period', 'is_active'],
                'tier_prices_active_lookup'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tier_prices', function (Blueprint $table) {
            $table->dropIndex('tier_prices_active_lookup');
            $table->dropUnique('tier_prices_version_unique');
            $table->dropUnique(['stripe_id']);
            $table->dropColumn(['is_active', 'pricing_version']);
        });
    }
};
