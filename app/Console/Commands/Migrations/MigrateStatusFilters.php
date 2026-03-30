<?php

namespace App\Console\Commands\Migrations;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateStatusFilters extends Command
{
    protected $signature = 'migrate:status-filters';

    protected $description = 'Migrate old status filter params in bookmarks and dashboard widgets to the new status_id format';

    /** @var array<string, array<string, string>> Old boolean column → status key, keyed by entity type code */
    protected array $booleanMap = [
        'creature' => ['is_dead' => 'dead', 'is_extinct' => 'extinct'],
        'location' => ['is_destroyed' => 'destroyed'],
        'organisation' => ['is_defunct' => 'defunct'],
        'race' => ['is_extinct' => 'extinct'],
        'family' => ['is_extinct' => 'extinct'],
    ];

    /** @var array<int, string> Character old enum value → status key */
    protected array $characterMap = [0 => 'alive', 1 => 'dead', 2 => 'missing'];

    /** @var array<int, string> Quest old enum value → status key */
    protected array $questMap = [0 => 'not_started', 1 => 'ongoing', 2 => 'completed', 3 => 'abandoned'];

    /** @var array<int, array<string, int>> Cached category_status IDs keyed by entity_type_id then status key */
    protected array $statusCache = [];

    public function handle(): void
    {
        $this->migrateBookmarks();
        $this->migrateWidgets();

        $this->info('Finished migrating status filters.');
    }

    protected function migrateBookmarks(): void
    {
        $bookmarks = DB::table('bookmarks')
            ->whereNotNull('filters')
            ->where('filters', '!=', '')
            ->whereNotNull('entity_type_id')
            ->get(['id', 'filters', 'entity_type_id']);

        $updated = 0;
        foreach ($bookmarks as $bookmark) {
            $params = $this->parseFilterString($bookmark->filters);
            if ($this->migrateFilterParams($params, $bookmark->entity_type_id)) {
                DB::table('bookmarks')
                    ->where('id', $bookmark->id)
                    ->update(['filters' => $this->buildFilterString($params)]);
                $updated++;
            }
        }

        $this->info("Bookmarks: {$updated} updated.");
    }

    protected function migrateWidgets(): void
    {
        $widgets = DB::table('campaign_dashboard_widgets')
            ->whereNotNull('entity_type_id')
            ->whereNotNull('config')
            ->get(['id', 'config', 'entity_type_id']);

        $updated = 0;
        foreach ($widgets as $widget) {
            $config = json_decode($widget->config, true);
            if (empty($config['filters']) || ! is_string($config['filters'])) {
                continue;
            }

            $params = $this->parseFilterString($config['filters']);
            if ($this->migrateFilterParams($params, $widget->entity_type_id)) {
                $config['filters'] = $this->buildFilterString($params);
                DB::table('campaign_dashboard_widgets')
                    ->where('id', $widget->id)
                    ->update(['config' => json_encode($config)]);
                $updated++;
            }
        }

        $this->info("Widgets: {$updated} updated.");
    }

    /**
     * Replace old status filter params with the new status_id param.
     *
     * @return bool True if any changes were made
     */
    protected function migrateFilterParams(array &$params, int $entityTypeId): bool
    {
        $changed = false;

        // Handle character/quest enum status_id values
        $characterTypeId = config('entities.ids.character');
        $questTypeId = config('entities.ids.quest');

        if (isset($params['status_id']) && ($entityTypeId === $characterTypeId || $entityTypeId === $questTypeId)) {
            $oldValue = (int) $params['status_id'];
            $map = $entityTypeId === $characterTypeId ? $this->characterMap : $this->questMap;

            if (isset($map[$oldValue])) {
                $statusId = $this->resolveStatusId($entityTypeId, $map[$oldValue]);
                if ($statusId !== null) {
                    $params['status_id'] = (string) $statusId;
                    $changed = true;
                }
            }
        }

        // Handle boolean columns (is_dead, is_defunct, is_destroyed, is_extinct)
        $entityTypeCode = $this->resolveEntityTypeCode($entityTypeId);
        if ($entityTypeCode === null || ! isset($this->booleanMap[$entityTypeCode])) {
            return $changed;
        }

        foreach ($this->booleanMap[$entityTypeCode] as $oldParam => $statusKey) {
            if (! isset($params[$oldParam])) {
                continue;
            }

            $oldValue = (int) $params[$oldParam];
            unset($params[$oldParam]);
            $changed = true;

            // Value of 0 means "not this status", just remove the old param
            if ($oldValue === 0) {
                continue;
            }

            $statusId = $this->resolveStatusId($entityTypeId, $statusKey);
            if ($statusId !== null) {
                $params['status_id'] = (string) $statusId;
            }
        }

        return $changed;
    }

    protected function resolveStatusId(int $entityTypeId, string $key): ?int
    {
        if (! isset($this->statusCache[$entityTypeId])) {
            $this->statusCache[$entityTypeId] = DB::table('category_statuses')
                ->where('category_id', $entityTypeId)
                ->pluck('id', 'key')
                ->toArray();
        }

        return $this->statusCache[$entityTypeId][$key] ?? null;
    }

    protected function resolveEntityTypeCode(int $entityTypeId): ?string
    {
        $ids = config('entities.ids');
        foreach ($ids as $code => $id) {
            if ($id === $entityTypeId) {
                return $code;
            }
        }

        return null;
    }

    /**
     * @return array<string, string>
     */
    protected function parseFilterString(string $filters): array
    {
        $params = [];
        $segments = explode('&', $filters);
        foreach ($segments as $segment) {
            if (empty($segment)) {
                continue;
            }
            $parts = explode('=', $segment, 2);
            $params[$parts[0]] = $parts[1] ?? '';
        }

        return $params;
    }

    /**
     * @param  array<string, string>  $params
     */
    protected function buildFilterString(array $params): string
    {
        $segments = [];
        foreach ($params as $key => $value) {
            $segments[] = $key . '=' . $value;
        }

        return implode('&', $segments);
    }
}
