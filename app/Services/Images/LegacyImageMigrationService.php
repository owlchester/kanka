<?php

namespace App\Services\Images;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Throwable;

class LegacyImageMigrationService
{
    /** @var array<string, list<string>> */
    public const CONTENT_COLUMNS = [
        'entities' => ['entry', 'tooltip'],
        'posts' => ['entry'],
        'campaign_descriptions' => ['description', 'excerpt'],
        'attributes' => ['value'],
        'map_layers' => ['entry'],
        'map_markers' => ['entry'],
        'timeline_eras' => ['entry'],
        'timeline_elements' => ['entry'],
        'quest_elements' => ['entry'],
        'character_traits' => ['entry'],
        'inventories' => ['description'],
    ];

    /** @var array<string, list<string>> */
    public const PATH_COLUMNS = [
        'entities' => ['image_path', 'header_image'],
        'map_layers' => ['image_path'],
        'campaigns' => ['image', 'header_image'],
        'entity_assets' => ['metadata'],
    ];

    /**
     * Build the source and content-reference ledgers for a complete prefix.
     *
     * @return array{sources: int, references: int, blockers: int}
     */
    public function index(string $prefix, bool $rebuild = false): array
    {
        $this->startIndex($prefix, $rebuild);

        try {
            $this->inventorySources($prefix);
            DB::table('legacy_image_migration_references')->where('prefix', $prefix)->delete();

            foreach (self::CONTENT_COLUMNS as $table => $columns) {
                foreach ($columns as $column) {
                    $this->indexColumn($prefix, $table, $column);
                }
            }
            foreach (self::PATH_COLUMNS as $table => $columns) {
                foreach ($columns as $column) {
                    if ($table === 'entities' && $column === 'image_path') {
                        continue;
                    }
                    $this->indexStructuredColumn($prefix, $table, $column);
                }
            }

            $sources = DB::table('legacy_image_migrations')->where('prefix', $prefix)->count();
            $references = DB::table('legacy_image_migration_references')
                ->where('prefix', $prefix)
                ->whereNotNull('legacy_image_migration_id')
                ->count();
            $blockers = DB::table('legacy_image_migration_references')
                ->where('prefix', $prefix)
                ->where('status', 'blocker')
                ->count();

            DB::table('legacy_image_migration_indexes')->where('prefix', $prefix)->update([
                'status' => 'ready',
                'source_count' => $sources,
                'reference_count' => $references,
                'blocker_count' => $blockers,
                'indexed_at' => now(),
                'error' => null,
                'updated_at' => now(),
            ]);

            return compact('sources', 'references', 'blockers');
        } catch (Throwable $e) {
            DB::table('legacy_image_migration_indexes')->where('prefix', $prefix)->update([
                'status' => 'failed',
                'error' => $e->getMessage(),
                'updated_at' => now(),
            ]);

            throw $e;
        }
    }

    public function isIndexed(string $prefix): bool
    {
        return DB::table('legacy_image_migration_indexes')
            ->where('prefix', $prefix)
            ->where('status', 'ready')
            ->exists();
    }

    public function destination(int $campaignId, string $source): string
    {
        $cleanSource = preg_split('/[?#]/', $source, 2)[0];
        $extension = mb_strtolower(pathinfo($cleanSource, PATHINFO_EXTENSION));
        if (! preg_match('/^[a-z0-9]{1,10}$/', $extension)) {
            throw new RuntimeException("Invalid extension for {$source}");
        }

        $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, "kanka:legacy-image:{$campaignId}:{$source}")->toString();

        return "w/{$campaignId}/legacy/{$uuid}.{$extension}";
    }

    /**
     * Rewrite only rows recorded by the one-time prefix index.
     */
    public function rewriteIndexedReferences(int $migrationId, string $source, string $destination): int
    {
        $references = DB::table('legacy_image_migration_references')
            ->where('legacy_image_migration_id', $migrationId)
            ->where('status', 'pending')
            ->orderBy('id')
            ->get();
        $updatedRows = 0;

        foreach ($references as $reference) {
            $current = DB::table($reference->table_name)
                ->where('id', $reference->row_id)
                ->value($reference->column_name);
            $referenceSource = $this->referenceSource($current, $source);

            if (! is_string($current) || $referenceSource === null) {
                DB::table('legacy_image_migration_references')->where('id', $reference->id)->update([
                    'status' => 'resolved',
                    'updated_at' => now(),
                ]);

                continue;
            }

            if ($this->containsSignedThumborReference($current, $referenceSource)) {
                throw new RuntimeException("Signed Thumbor reference found in {$reference->table_name}.{$reference->column_name} row {$reference->row_id}");
            }

            $updated = $this->rewriteValue($current, $referenceSource, $destination);
            if ($updated === $current || str_contains($updated, $referenceSource)) {
                throw new RuntimeException("Unresolved reference in {$reference->table_name}.{$reference->column_name} row {$reference->row_id}");
            }

            $affected = DB::table($reference->table_name)
                ->where('id', $reference->row_id)
                ->where($reference->column_name, $current)
                ->update([$reference->column_name => $updated]);

            if ($affected !== 1) {
                throw new RuntimeException("Concurrent update in {$reference->table_name}.{$reference->column_name} row {$reference->row_id}");
            }

            DB::table('legacy_image_migration_references')->where('id', $reference->id)->update([
                'value_hash' => hash('sha256', $updated),
                'status' => 'resolved',
                'updated_at' => now(),
            ]);
            $updatedRows++;
        }

        return $updatedRows;
    }

    public function hasBlockers(int $migrationId): bool
    {
        return DB::table('legacy_image_migration_references')
            ->where('legacy_image_migration_id', $migrationId)
            ->where('status', 'blocker')
            ->exists();
    }

    public function rewriteValue(string $value, string $source, string $destination): string
    {
        $destinationUrl = rtrim((string) config('cdn.ugc'), '/') . '/' . $destination;
        if (empty(config('cdn.ugc'))) {
            $destinationUrl = Storage::disk('s3')->url($destination);
        }

        foreach ($this->knownBases() as $base) {
            $value = str_replace($base . '/' . $source, $destinationUrl, $value);
        }

        $pattern = '~(?<before>^|[\s\"\'=(/])' . preg_quote($source, '~') . '(?=$|[?#\s\"\')>])~u';

        return preg_replace_callback(
            $pattern,
            fn (array $matches): string => $matches['before'] . $destination,
            $value
        ) ?? $value;
    }

    /** @return array{structured: int, content: int, blockers: int} */
    public function remainingReferences(string $prefix): array
    {
        $structured = 0;
        $content = 0;

        foreach (self::PATH_COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                $structured += DB::table($table)->where($column, 'like', '%' . $prefix . '%')->count();
            }
        }

        foreach (self::CONTENT_COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                $content += DB::table($table)->where($column, 'like', '%' . $prefix . '%')->count();
            }
        }

        $blockers = DB::table('legacy_image_migration_references')
            ->where('prefix', $prefix)
            ->where('status', 'blocker')
            ->count();

        return compact('structured', 'content', 'blockers');
    }

    protected function startIndex(string $prefix, bool $rebuild): void
    {
        if ($this->isIndexed($prefix) && ! $rebuild) {
            throw new RuntimeException("{$prefix} is already indexed; use --rebuild-index to scan it again.");
        }

        DB::table('legacy_image_migration_indexes')->updateOrInsert(
            ['prefix' => $prefix],
            [
                'status' => 'indexing',
                'error' => null,
                'updated_at' => now(),
                'created_at' => DB::table('legacy_image_migration_indexes')->where('prefix', $prefix)->value('created_at') ?? now(),
            ]
        );
    }

    protected function inventorySources(string $prefix): void
    {
        DB::table('legacy_image_migrations')
            ->whereNull('prefix')
            ->where('source_path', 'like', $prefix . '%')
            ->update(['prefix' => $prefix, 'updated_at' => now()]);

        $this->owners($prefix)->chunkById(1000, function ($owners) use ($prefix) {
            $now = now();
            $rows = [];

            foreach ($owners as $owner) {
                $source = (string) $owner->source_path;
                $rows[] = [
                    'source_hash' => hash('sha256', $source),
                    'prefix' => $prefix,
                    'source_path' => $source,
                    'destination_path' => $this->destination((int) $owner->campaign_id, $source),
                    'campaign_id' => $owner->campaign_id,
                    'entity_id' => $owner->entity_id,
                    'status' => 'pending',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('legacy_image_migrations')->upsert(
                $rows,
                ['source_hash'],
                ['prefix', 'source_path', 'destination_path', 'campaign_id', 'entity_id', 'updated_at']
            );
        }, 'owner.entity_id', 'entity_id');
    }

    protected function owners(string $prefix): Builder
    {
        $owners = DB::table('entities')
            ->selectRaw('image_path AS source_path, MIN(id) AS entity_id')
            ->where('image_path', 'like', $prefix . '%')
            ->groupBy('image_path');

        return DB::query()
            ->fromSub($owners, 'owner')
            ->join('entities', 'entities.id', '=', 'owner.entity_id')
            ->select(['owner.source_path', 'owner.entity_id', 'entities.campaign_id']);
    }

    protected function indexColumn(string $prefix, string $table, string $column): void
    {
        DB::table($table)
            ->select(['id', $column])
            ->where($column, 'like', '%' . $prefix . '%')
            ->orderBy('id')
            ->chunkById(500, function ($records) use ($prefix, $table, $column) {
                foreach ($records as $record) {
                    $value = $record->{$column};
                    if (! is_string($value)) {
                        continue;
                    }

                    $sources = $this->extractSources($value, $prefix);
                    if (empty($sources)) {
                        $this->storeReference(null, $prefix, $table, $column, $record->id, $value, 'blocker', 'Unrecognized prefix reference');

                        continue;
                    }

                    foreach ($sources as $source) {
                        $migration = $this->resolveMigration($source);
                        $migrationId = $migration?->id;
                        $error = null;
                        $status = 'pending';

                        if (! $migrationId) {
                            $status = 'blocker';
                            $error = "No owning entity for {$source}";
                        } else {
                            if (empty($migration->prefix)) {
                                DB::table('legacy_image_migrations')->where('id', $migrationId)->update([
                                    'prefix' => $prefix,
                                    'updated_at' => now(),
                                ]);
                            }
                        }

                        if ($migrationId && $this->containsSignedThumborReference($value, $source)) {
                            $status = 'blocker';
                            $error = "Signed Thumbor reference for {$source}";
                        }

                        $this->storeReference($migrationId, $prefix, $table, $column, $record->id, $value, $status, $error);
                    }
                }
            }, 'id');
    }

    protected function indexStructuredColumn(string $prefix, string $table, string $column): void
    {
        DB::table($table)
            ->select(['id', $column])
            ->where($column, 'like', '%' . $prefix . '%')
            ->orderBy('id')
            ->chunkById(500, function ($records) use ($prefix, $table, $column) {
                foreach ($records as $record) {
                    $value = $record->{$column};
                    if (! is_string($value)) {
                        continue;
                    }

                    $sources = $this->extractSources($value, $prefix);
                    if (empty($sources)) {
                        $this->storeReference(null, $prefix, $table, $column, $record->id, $value, 'blocker', 'Unrecognized structured reference');

                        continue;
                    }

                    foreach ($sources as $source) {
                        $migrationId = $this->resolveMigration($source)?->id;

                        $this->storeReference(
                            $migrationId,
                            $prefix,
                            $table,
                            $column,
                            $record->id,
                            $value,
                            'blocker',
                            "Structured reference requires a separate migration: {$source}"
                        );
                    }
                }
            }, 'id');
    }

    /** @return list<string> */
    protected function extractSources(string $value, string $prefix): array
    {
        $sources = [];
        foreach ($this->knownBases() as $base) {
            $pattern = '~' . preg_quote($base . '/', '~') . '(' . preg_quote($prefix, '~') . '[^\s\"\'<>?#)]+)~u';
            preg_match_all($pattern, $value, $matches);
            foreach ($matches[1] as $source) {
                $sources[$source] = true;
            }
        }

        $relativePattern = '~(?<![a-zA-Z0-9_.-])/?(' . preg_quote($prefix, '~') . '[^\s\"\'<>?#)]+)~u';
        preg_match_all($relativePattern, $value, $relativeMatches);
        foreach ($relativeMatches[1] as $source) {
            $sources[$source] = true;
        }

        return array_keys($sources);
    }

    protected function storeReference(
        mixed $migrationId,
        string $prefix,
        string $table,
        string $column,
        mixed $rowId,
        string $value,
        string $status,
        ?string $error
    ): void {
        DB::table('legacy_image_migration_references')->updateOrInsert(
            [
                'legacy_image_migration_id' => $migrationId,
                'prefix' => $prefix,
                'table_name' => $table,
                'column_name' => $column,
                'row_id' => $rowId,
            ],
            [
                'value_hash' => hash('sha256', $value),
                'status' => $status,
                'error' => $error,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    protected function resolveMigration(string $source): ?object
    {
        $migration = DB::table('legacy_image_migrations')
            ->where('source_hash', hash('sha256', $source))
            ->first(['id', 'prefix']);
        if ($migration) {
            return $migration;
        }

        $matches = DB::table('legacy_image_migrations')
            ->where(function ($query) use ($source) {
                $query->where('source_path', 'like', $source . '?%')
                    ->orWhere('source_path', 'like', $source . '#%');
            })
            ->limit(2)
            ->get(['id', 'prefix']);

        return $matches->count() === 1 ? $matches->first() : null;
    }

    protected function referenceSource(mixed $value, string $source): ?string
    {
        if (! is_string($value)) {
            return null;
        }
        if (str_contains($value, $source)) {
            return $source;
        }

        $cleanSource = preg_split('/[?#]/', $source, 2)[0];

        return $cleanSource !== $source && str_contains($value, $cleanSource) ? $cleanSource : null;
    }

    /** @return list<string> */
    protected function knownBases(): array
    {
        return array_values(array_filter(array_unique([
            rtrim((string) config('cdn.ugc'), '/'),
            'https://cdn-ugc.kanka.io',
            'https://kanka-user-assets.s3.eu-central-1.amazonaws.com',
        ])));
    }

    protected function containsSignedThumborReference(string $value, string $source): bool
    {
        if (! str_contains($value, $source)) {
            return false;
        }

        $thumborHost = parse_url((string) config('thumbor.url'), PHP_URL_HOST);

        return str_contains($value, 'th.kanka.io') || ($thumborHost && str_contains($value, $thumborHost));
    }
}
