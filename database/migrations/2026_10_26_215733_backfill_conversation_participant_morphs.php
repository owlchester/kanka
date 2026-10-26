<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $characterTypeId = DB::table('entity_types')->where('code', 'character')->value('id');

        foreach (['conversation_participants', 'conversation_messages'] as $tableName) {
            DB::table($tableName)->whereNotNull('user_id')->update([
                'participant_type' => 'App\\Models\\User',
                'participant_id' => DB::raw('user_id'),
            ]);

            if ($characterTypeId === null) {
                continue;
            }

            DB::table($tableName)
                ->join('characters', $tableName . '.character_id', '=', 'characters.id')
                ->join('entities', function ($join) use ($characterTypeId) {
                    $join->on('entities.entity_id', '=', 'characters.id')
                        ->where('entities.type_id', '=', $characterTypeId);
                })
                ->whereNull($tableName . '.user_id')
                ->whereNull($tableName . '.participant_id')
                ->update([
                    $tableName . '.participant_type' => 'App\\Models\\Entity',
                    $tableName . '.participant_id' => DB::raw('entities.id'),
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('conversation_participants')->update(['participant_type' => null, 'participant_id' => null]);
        DB::table('conversation_messages')->update(['participant_type' => null, 'participant_id' => null]);
    }
};
