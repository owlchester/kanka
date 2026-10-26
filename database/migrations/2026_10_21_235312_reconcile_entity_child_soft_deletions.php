<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $tables = [
        'abilities' => 'ability',
        'attribute_templates' => 'attribute_template',
        'calendars' => 'calendar',
        'characters' => 'character',
        'conversations' => 'conversation',
        'creatures' => 'creature',
        'dice_rolls' => 'dice_roll',
        'events' => 'event',
        'families' => 'family',
        'items' => 'item',
        'journals' => 'journal',
        'locations' => 'location',
        'maps' => 'map',
        'notes' => 'note',
        'organisations' => 'organisation',
        'quests' => 'quest',
        'races' => 'race',
        'tags' => 'tag',
        'timelines' => 'timeline',
        'whiteboards' => 'whiteboard',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table => $code) {
            DB::table('entities')
                ->whereNull('deleted_at')
                ->whereIn('type_id', DB::table('entity_types')->select('id')->where('code', $code)->whereNull('campaign_id'))
                ->whereExists(fn ($child) => $child->selectRaw('1')
                    ->from($table)
                    ->whereColumn($table . '.id', 'entities.entity_id')
                    ->whereNotNull($table . '.deleted_at'))
                ->update([
                    'deleted_at' => DB::raw('(SELECT ' . $table . '.deleted_at FROM ' . $table . ' WHERE ' . $table . '.id = entities.entity_id)'),
                ]);
        }
    }

    public function down(): void
    {
        // The schema migration restores the columns first. Project current entity state back
        // to them, rather than resurrecting deleted children when rolling back the application.
        foreach ($this->tables as $table => $code) {
            $typeId = DB::table('entity_types')->where('code', $code)->whereNull('campaign_id')->value('id');
            if ($typeId === null) {
                continue;
            }

            DB::table($table)->update([
                'deleted_at' => DB::raw('(SELECT entities.deleted_at FROM entities WHERE entities.entity_id = ' . $table . '.id AND entities.type_id = ' . (int) $typeId . ' LIMIT 1)'),
            ]);
        }
    }
};
