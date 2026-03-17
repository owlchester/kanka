<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VerifyParentIds extends Command
{
    protected $signature = 'parent:verify';

    protected $description = 'Report mismatches between child table parent keys and entities.parent_id';

    public function handle(): int
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

        $totalMismatches = 0;

        foreach ($models as $table => $config) {
            // Find entities where child has a parent but entities.parent_id doesn't match
            $mismatches = DB::select("
                SELECT e.id AS entity_id, e.name, e.parent_id AS entity_parent_id,
                       c.{$config['key']} AS child_parent_id,
                       parent_entity.id AS expected_parent_id
                FROM entities e
                JOIN {$table} c ON e.entity_id = c.id AND e.type_id = {$config['type_id']}
                LEFT JOIN entities parent_entity ON parent_entity.entity_id = c.{$config['key']}
                    AND parent_entity.type_id = {$config['type_id']}
                WHERE (
                    (c.{$config['key']} IS NOT NULL AND (e.parent_id IS NULL OR e.parent_id != parent_entity.id))
                    OR (c.{$config['key']} IS NULL AND e.parent_id IS NOT NULL)
                )
                AND e.deleted_at IS NULL
            ");

            if (count($mismatches) > 0) {
                $this->warn("{$table}: " . count($mismatches) . ' mismatches');
                foreach ($mismatches as $row) {
                    $this->line("  Entity #{$row->entity_id} ({$row->name}): entity.parent_id={$row->entity_parent_id}, child.{$config['key']}={$row->child_parent_id}, expected={$row->expected_parent_id}");
                }
                $totalMismatches += count($mismatches);
            } else {
                $this->info("{$table}: OK");
            }
        }

        if ($totalMismatches === 0) {
            $this->info('All parent IDs are in sync.');

            return self::SUCCESS;
        }

        $this->error("Total mismatches: {$totalMismatches}");

        return self::FAILURE;
    }
}
