<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $models = [
            'abilities' => ['key' => 'ability_id',            'type_id' => config('entities.ids.ability')],
            'attribute_templates' => ['key' => 'attribute_template_id', 'type_id' => config('entities.ids.attribute_template')],
            'calendars' => ['key' => 'calendar_id',           'type_id' => config('entities.ids.calendar')],
            'creatures' => ['key' => 'creature_id',           'type_id' => config('entities.ids.creature')],
            'events' => ['key' => 'event_id',              'type_id' => config('entities.ids.event')],
            'families' => ['key' => 'family_id',             'type_id' => config('entities.ids.family')],
            'items' => ['key' => 'item_id',               'type_id' => config('entities.ids.item')],
            'journals' => ['key' => 'journal_id',            'type_id' => config('entities.ids.journal')],
            'locations' => ['key' => 'location_id',           'type_id' => config('entities.ids.location')],
            'maps' => ['key' => 'map_id',                'type_id' => config('entities.ids.map')],
            'notes' => ['key' => 'note_id',               'type_id' => config('entities.ids.note')],
            'organisations' => ['key' => 'organisation_id',       'type_id' => config('entities.ids.organisation')],
            'quests' => ['key' => 'quest_id',              'type_id' => config('entities.ids.quest')],
            'races' => ['key' => 'race_id',               'type_id' => config('entities.ids.race')],
            'tags' => ['key' => 'tag_id',                'type_id' => config('entities.ids.tag')],
            'timelines' => ['key' => 'timeline_id',           'type_id' => config('entities.ids.timeline')],
        ];

        foreach ($models as $table => $config) {
            DB::statement("
                UPDATE entities e
                JOIN {$table} c ON e.entity_id = c.id AND e.type_id = {$config['type_id']}
                JOIN {$table} parent_child ON c.{$config['key']} = parent_child.id
                JOIN entities parent_entity ON parent_entity.entity_id = parent_child.id
                    AND parent_entity.type_id = {$config['type_id']}
                SET e.parent_id = parent_entity.id
                WHERE c.{$config['key']} IS NOT NULL
                    AND e.parent_id IS NULL
            ");
        }
    }

    public function down(): void
    {
        // The old child table columns still exist, so no data is lost.
        // Nullify entities.parent_id for standard types only.
        $standardTypeIds = [
            config('entities.ids.ability'),
            config('entities.ids.attribute_template'),
            config('entities.ids.calendar'),
            config('entities.ids.creature'),
            config('entities.ids.event'),
            config('entities.ids.family'),
            config('entities.ids.item'),
            config('entities.ids.journal'),
            config('entities.ids.location'),
            config('entities.ids.map'),
            config('entities.ids.note'),
            config('entities.ids.organisation'),
            config('entities.ids.quest'),
            config('entities.ids.race'),
            config('entities.ids.tag'),
            config('entities.ids.timeline'),
        ];

        DB::table('entities')
            ->whereIn('type_id', $standardTypeIds)
            ->update(['parent_id' => null]);
    }
};
