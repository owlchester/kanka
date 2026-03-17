<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'abilities' => 'ability_id',
            'attribute_templates' => 'attribute_template_id',
            'calendars' => 'calendar_id',
            'creatures' => 'creature_id',
            'events' => 'event_id',
            'families' => 'family_id',
            'items' => 'item_id',
            'journals' => 'journal_id',
            'maps' => 'map_id',
            'notes' => 'note_id',
            'organisations' => 'organisation_id',
            'quests' => 'quest_id',
            'races' => 'race_id',
            'tags' => 'tag_id',
            'timelines' => 'timeline_id',
        ];

        foreach ($columns as $table => $column) {
            if (Schema::hasColumn($table, $column)) {
                Schema::table($table, function (Blueprint $table) use ($column) {
                    $table->dropForeign($table->getTable() . '_' . $column . '_foreign');
                    $table->dropColumn($column);
                });
            }
        }

        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_parent_id_foreign');
            $table->dropColumn('parent_id');
        });
    }

    public function down(): void
    {
        $columns = [
            'abilities' => 'ability_id',
            'attribute_templates' => 'attribute_template_id',
            'calendars' => 'calendar_id',
            'creatures' => 'creature_id',
            'events' => 'event_id',
            'families' => 'family_id',
            'items' => 'item_id',
            'journals' => 'journal_id',
            'locations' => 'location_id',
            'maps' => 'map_id',
            'notes' => 'note_id',
            'organisations' => 'organisation_id',
            'quests' => 'quest_id',
            'races' => 'race_id',
            'tags' => 'tag_id',
            'timelines' => 'timeline_id',
        ];

        foreach ($columns as $table => $column) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->unsignedInteger($column)->nullable();
            });
        }
    }
};
