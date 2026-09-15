<?php

use App\Models\EntityType;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This migration predates campaign-scoped entity types, so the
        // campaign_id column is not available yet.
        $type = EntityType::where('code', 'bookmark')->first();
        if (! $type) {
            return;
        }
        $type->code = 'bookmark';
        $type->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
