<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            UPDATE items
            JOIN entities ON entities.entity_id = items.character_id
                AND entities.type_id = 1
            SET items.creator_id = entities.id
            WHERE items.character_id IS NOT NULL
        ');
    }

    public function down(): void
    {
        // Safely undo: only null creator_id if it matches the expected entity
        DB::statement('
            UPDATE items
            JOIN entities ON entities.entity_id = items.character_id
                AND entities.type_id = 1
            SET items.creator_id = NULL
            WHERE items.creator_id = entities.id
        ');
    }
};
