<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("UPDATE reminders SET remindable_type = 'App\\\Models\\\Entity', remindable_id = entity_id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('UPDATE reminders SET remindable_type = null, remindable_id = null');
    }
};
