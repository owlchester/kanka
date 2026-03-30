<?php

namespace App\Console\Commands\Migrations;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateEntityStatuses extends Command
{
    protected $signature = 'migrate:entity-statuses';

    protected $description = 'Migrate statuses from child tables to the entities table';

    public function handle(): void
    {
        $this->migrateCharacters();
        $this->migrateQuests();

        $this->migrateBooleans('creature', 'creatures', [
            'is_dead' => 'dead',
            'is_extinct' => 'extinct',
        ]);
        $this->migrateBooleans('location', 'locations', [
            'is_destroyed' => 'destroyed',
        ]);
        $this->migrateBooleans('organisation', 'organisations', [
            'is_defunct' => 'defunct',
        ]);
        $this->migrateBooleans('race', 'races', [
            'is_extinct' => 'extinct',
        ]);
        $this->migrateBooleans('family', 'families', [
            'is_extinct' => 'extinct',
        ]);

        $this->info('Finished migrating entity statuses.');
    }

    /**
     * Migrate character statuses (0=alive, 1=dead, 2=missing) to entities.status_id.
     */
    protected function migrateCharacters(): void
    {
        $characterTypeId = config('entities.ids.character');

        $mapping = [
            0 => 'alive',
            1 => 'dead',
            2 => 'missing',
        ];

        $statusIds = $this->getCategoryStatusIds($characterTypeId, $mapping);

        foreach ($mapping as $oldValue => $key) {
            if (! isset($statusIds[$key])) {
                $this->warn("Category status '{$key}' not found for characters, skipping.");
                continue;
            }

            $updated = DB::table('entities')
                ->join('characters', function ($join) use ($characterTypeId) {
                    $join->on('entities.entity_id', '=', 'characters.id')
                        ->where('entities.type_id', '=', $characterTypeId);
                })
                ->where('characters.status_id', $oldValue)
                ->update(['entities.status_id' => $statusIds[$key]]);

            $this->info("Characters [{$key}]: {$updated} entities updated.");
        }
    }

    /**
     * Migrate quest statuses (0=notStarted, 1=ongoing, 2=completed, 3=abandoned) to entities.status_id.
     */
    protected function migrateQuests(): void
    {
        $questTypeId = config('entities.ids.quest');

        $mapping = [
            0 => 'not_started',
            1 => 'ongoing',
            2 => 'completed',
            3 => 'abandoned',
        ];

        $statusIds = $this->getCategoryStatusIds($questTypeId, $mapping);

        foreach ($mapping as $oldValue => $key) {
            if (! isset($statusIds[$key])) {
                $this->warn("Category status '{$key}' not found for quests, skipping.");
                continue;
            }

            $updated = DB::table('entities')
                ->join('quests', function ($join) use ($questTypeId) {
                    $join->on('entities.entity_id', '=', 'quests.id')
                        ->where('entities.type_id', '=', $questTypeId);
                })
                ->where('quests.status_id', $oldValue)
                ->update(['entities.status_id' => $statusIds[$key]]);

            $this->info("Quests [{$key}]: {$updated} entities updated.");
        }
    }

    /**
     * Migrate boolean columns (is_dead, is_extinct, etc.) to entities.status_id.
     *
     * @param  array<string, string>  $columns  [boolean_column => status_key]
     */
    protected function migrateBooleans(string $entityTypeKey, string $table, array $columns): void
    {
        $typeId = config('entities.ids.' . $entityTypeKey);
        $statusIds = $this->getCategoryStatusIds($typeId, $columns);

        foreach ($columns as $column => $key) {
            if (! isset($statusIds[$key])) {
                $this->warn("Category status '{$key}' not found for {$table}, skipping.");
                continue;
            }

            $updated = DB::table('entities')
                ->join($table, function ($join) use ($table, $typeId) {
                    $join->on('entities.entity_id', '=', $table . '.id')
                        ->where('entities.type_id', '=', $typeId);
                })
                ->where($table . '.' . $column, true)
                ->whereNull('entities.status_id')
                ->update(['entities.status_id' => $statusIds[$key]]);

            $this->info(ucfirst($entityTypeKey) . " [{$key}]: {$updated} entities updated.");
        }
    }

    /**
     * Get category_statuses.id keyed by status key for a given entity type.
     *
     * @param  array<int|string, string>  $mapping
     * @return array<string, int>
     */
    protected function getCategoryStatusIds(int $categoryId, array $mapping): array
    {
        return DB::table('category_statuses')
            ->where('category_id', $categoryId)
            ->whereIn('key', array_values($mapping))
            ->pluck('id', 'key')
            ->toArray();
    }
}
