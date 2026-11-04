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
        foreach (['conversation_participants', 'conversation_messages'] as $tableName) {
            if (DB::table($tableName)->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereNotNull('character_id')->whereNull('participant_id');
                })->orWhere(function ($query) {
                    $query->whereNotNull('user_id')->whereNull('participant_id');
                });
            })->exists()) {
                throw new RuntimeException("Cannot drop legacy author IDs from {$tableName}: the morph backfill is incomplete.");
            }
        }

        foreach (['conversation_participants', 'conversation_messages'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['character_id']);
                $table->dropForeign(['user_id']);
                $table->dropColumn(['character_id', 'user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('conversation_participants')->where('participant_type', 'App\\Models\\Entity')->whereNotIn('participant_id', function ($query) {
            $query->select('id')->from('entities')->where('type_id', DB::table('entity_types')->where('code', 'character')->value('id'));
        })->exists() || DB::table('conversation_messages')->where('participant_type', 'App\\Models\\Entity')->whereNotIn('participant_id', function ($query) {
            $query->select('id')->from('entities')->where('type_id', DB::table('entity_types')->where('code', 'character')->value('id'));
        })->exists()) {
            throw new RuntimeException('Cannot restore character-only conversation author columns while non-character entities participate.');
        }

        Schema::table('conversation_participants', function (Blueprint $table) {
            $table->unsignedInteger('character_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::table('conversation_messages', function (Blueprint $table) {
            $table->unsignedInteger('character_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('character_id')->references('id')->on('characters')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        $characterTypeId = DB::table('entity_types')->where('code', 'character')->value('id');
        foreach (['conversation_participants', 'conversation_messages'] as $tableName) {
            DB::table($tableName)->where('participant_type', 'App\\Models\\User')->update(['user_id' => DB::raw('participant_id')]);
            if ($characterTypeId === null) {
                continue;
            }
            DB::table($tableName)
                ->join('entities', $tableName . '.participant_id', '=', 'entities.id')
                ->join('characters', function ($join) use ($characterTypeId) {
                    $join->on('entities.entity_id', '=', 'characters.id')
                        ->where('entities.type_id', '=', $characterTypeId);
                })
                ->where($tableName . '.participant_type', 'App\\Models\\Entity')
                ->update([$tableName . '.character_id' => DB::raw('characters.id')]);
        }
    }
};
