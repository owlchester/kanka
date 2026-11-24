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
        Schema::table('category_statuses', function (Blueprint $table) {
            $table->string('label', 45)->nullable();
            $table->index(['campaign_id', 'category_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_statuses', function (Blueprint $table) {
            $table->dropIndex(['campaign_id', 'category_id', 'sort_order']);
            $table->dropColumn('label');
        });
    }
};
