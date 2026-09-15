<?php

use App\Models\EntityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $typeIds = EntityType::default()
            ->inCodes([
                'ability', 'attribute_template', 'calendar', 'creature', 'event',
                'family', 'item', 'journal', 'location', 'map', 'note',
                'organisation', 'quest', 'race', 'tag', 'timeline',
            ])
            ->pluck('id', 'code');

        $models = [
            'abilities' => ['key' => 'ability_id', 'type' => 'ability'],
            'attribute_templates' => ['key' => 'attribute_template_id', 'type' => 'attribute_template'],
            'calendars' => ['key' => 'calendar_id', 'type' => 'calendar'],
            'creatures' => ['key' => 'creature_id', 'type' => 'creature'],
            'events' => ['key' => 'event_id', 'type' => 'event'],
            'families' => ['key' => 'family_id', 'type' => 'family'],
            'items' => ['key' => 'item_id', 'type' => 'item'],
            'journals' => ['key' => 'journal_id', 'type' => 'journal'],
            'locations' => ['key' => 'location_id', 'type' => 'location'],
            'maps' => ['key' => 'map_id', 'type' => 'map'],
            'notes' => ['key' => 'note_id', 'type' => 'note'],
            'organisations' => ['key' => 'organisation_id', 'type' => 'organisation'],
            'quests' => ['key' => 'quest_id', 'type' => 'quest'],
            'races' => ['key' => 'race_id', 'type' => 'race'],
            'tags' => ['key' => 'tag_id', 'type' => 'tag'],
            'timelines' => ['key' => 'timeline_id', 'type' => 'timeline'],
        ];

        if (DB::connection()->getDriverName() !== 'sqlite') {
            foreach ($models as $table => $model) {
                $typeId = $typeIds->get($model['type'], 0);
                DB::statement("
                    UPDATE entities e
                    JOIN {$table} c ON e.entity_id = c.id AND e.type_id = {$typeId}
                    JOIN {$table} parent_child ON c.{$model['key']} = parent_child.id
                    JOIN entities parent_entity ON parent_entity.entity_id = parent_child.id
                        AND parent_entity.type_id = {$typeId}
                    SET e.parent_id = parent_entity.id
                    WHERE c.{$model['key']} IS NOT NULL
                        AND e.parent_id IS NULL
                ");
            }
        }
    }

    public function down(): void
    {
        // The old child table columns still exist, so no data is lost.
        // Nullify entities.parent_id for standard types only.
        $standardTypeIds = EntityType::default()
            ->inCodes([
                'ability', 'attribute_template', 'calendar', 'creature', 'event',
                'family', 'item', 'journal', 'location', 'map', 'note',
                'organisation', 'quest', 'race', 'tag', 'timeline',
            ])
            ->pluck('id')
            ->all();

        DB::table('entities')
            ->whereIn('type_id', $standardTypeIds)
            ->update(['parent_id' => null]);
    }
};
