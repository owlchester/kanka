<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var list<string> */
    protected array $tables = [
        'attribute_templates',
        'calendars',
        'campaign_boosts',
        'campaign_styles',
        'characters',
        'conversations',
        'creatures',
        'dice_rolls',
        'events',
        'families',
        'items',
        'journals',
        'locations',
        'maps',
        'notes',
        'organisations',
        'plugins',
        'quests',
        'races',
        'tags',
        'themes',
        'timelines',
        'whiteboards',
        'whiteboard_shapes',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }
            Schema::table($tableName, function (Blueprint $table) {
                $table->index('deleted_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex(['deleted_at']);
            });
        }
    }
};
