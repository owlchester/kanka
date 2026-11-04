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
        foreach (['conversation_participants', 'conversation_messages'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('participant_type')->nullable();
                $table->unsignedInteger('participant_id')->nullable();
                $table->index(['participant_type', 'participant_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['conversation_participants', 'conversation_messages'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex(['participant_type', 'participant_id']);
                $table->dropColumn(['participant_type', 'participant_id']);
            });
        }
    }
};
