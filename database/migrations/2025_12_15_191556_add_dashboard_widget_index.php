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
        Schema::table('entities', function (Blueprint $table) {
            $table->index(
                [
                    'campaign_id',
                    'type_id',
                    'archived_at',
                    'deleted_at',
                    'updated_at',
                ], 'dashboard_entity_list_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropIndex('dashboard_entity_list_idx');
        });
    }
};
