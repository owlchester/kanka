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
     * @return array{sources: int, references: int, blockers: int, source_blockers: int}
     */
    public function index(string $prefix, bool $rebuild = false): array
    {
        $this->startIndex($prefix, $rebuild);

        try {
            $this->inventorySources($prefix);
            DB::table('legacy_image_migration_references')->where('prefix', $prefix)->delete();

            if (! $this->skipsContentReferences($prefix)) {
                foreach (self::CONTENT_COLUMNS as $table => $columns) {
                    foreach ($columns as $column) {
                        $this->indexColumn($prefix, $table, $column);
                    }
                }
            }
            foreach (self::PATH_COLUMNS as $table => $columns) {
                foreach ($columns as $column) {
                    if (($table === 'entities' || $table === 'map_layers') && $column === 'image_path') {
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
            $sourceBlockers = DB::table('legacy_image_migrations')
                ->where('prefix', $prefix)
                ->where('status', 'blocked')
                ->count();

            DB::table('legacy_image_migration_indexes')->where('prefix', $prefix)->update([
                'status' => 'ready',
                'source_count' => $sources,
                'reference_count' => $references,
                'blocker_count' => $blockers + $sourceBlockers,
                'indexed_at' => now(),
                'error' => null,
                'updated_at' => now(),
            ]);

            return [
                'sources' => $sources,
                'references' => $references,
                'blockers' => $blockers,
                'source_blockers' => $sourceBlockers,
            ];
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

    public function destination(int $campaignId, string $source, ?string $extension = null): string
    {
        $cleanSource = preg_split('/[?#]/', $source, 2)[0];
        $extension ??= mb_strtolower(pathinfo($cleanSource, PATHINFO_EXTENSION));
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
        $destinationUrl = $this->destinationUrl($destination);

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

    public function rewriteSignedThumborReferences(int $migrationId, string $source, string $destination): int
    {
        $references = DB::table('legacy_image_migration_references')
            ->where('legacy_image_migration_id', $migrationId)
            ->where('status', 'blocker')
            ->where('error', 'like', 'Signed Thumbor reference%')
            ->orderBy('id')
            ->get();
        $updatedRows = 0;

        foreach ($references as $reference) {
            if (! isset(self::CONTENT_COLUMNS[$reference->table_name])
                || ! in_array($reference->column_name, self::CONTENT_COLUMNS[$reference->table_name], true)) {
                throw new RuntimeException("Refusing to rewrite signed URL in {$reference->table_name}.{$reference->column_name}");
            }

            $current = DB::table($reference->table_name)
                ->where('id', $reference->row_id)
                ->value($reference->column_name);
            if (! is_string($current)) {
                throw new RuntimeException("Missing signed URL value in {$reference->table_name}.{$reference->column_name} row {$reference->row_id}");
            }

            $updated = $this->rewriteSignedThumborValue($current, $source, $destination);
            if ($updated === $current) {
                throw new RuntimeException("Could not locate signed Thumbor URL in {$reference->table_name}.{$reference->column_name} row {$reference->row_id}");
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
                'error' => null,
                'updated_at' => now(),
            ]);
            $updatedRows++;
        }

        return $updatedRows;
    }

    public function rewriteSignedThumborValue(string $value, string $source, string $destination): string
    {
        $hosts = array_values(array_filter(array_unique([
            'th.kanka.io',
            parse_url((string) config('thumbor.url'), PHP_URL_HOST),
        ])));
        if (empty($hosts)) {
            return $value;
        }

        $hostPattern = implode('|', array_map(fn (string $host): string => preg_quote($host, '~'), $hosts));
        $pattern = '~(?:https?:)?//(?:' . $hostPattern . ')/[^\s"\'<>]+~iu';
        $cleanSource = preg_split('/[?#]/', $source, 2)[0];
        $destinationUrl = $this->destinationUrl($destination);

        return preg_replace_callback($pattern, function (array $matches) use ($source, $cleanSource, $destinationUrl): string {
            $url = $matches[0];
            $candidate = rtrim($url, '),;');
            if (! str_contains(html_entity_decode($candidate, ENT_QUOTES | ENT_HTML5), $source)
                && ! str_contains(html_entity_decode($candidate, ENT_QUOTES | ENT_HTML5), $cleanSource)) {
                return $url;
            }

            return $destinationUrl . mb_substr($url, mb_strlen($candidate));
        }, $value) ?? $value;
    }

    public function destinationUrl(string $destination): string
    {
        if (! empty(config('cdn.ugc'))) {
            return rtrim((string) config('cdn.ugc'), '/') . '/' . $destination;
        }

        return Storage::disk('s3')->url($destination);
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
                $resolution = $this->resolveSource($source);
                $destination = $resolution['extension'] === null
                    ? null
                    : $this->destination((int) $owner->campaign_id, $source, $resolution['extension']);
                $rows[] = [
                    'source_hash' => hash('sha256', $source),
                    'prefix' => $prefix,
                    'source_path' => $source,
                    'destination_path' => $destination,
                    'detected_mime' => $resolution['detected_mime'],
                    'source_content_type' => $resolution['source_content_type'],
                    'resolution_status' => $resolution['status'],
                    'resolved_at' => $resolution['status'] === 'resolved' ? $now : null,
                    'campaign_id' => $owner->campaign_id,
                    'entity_id' => $owner->entity_id,
                    'status' => $resolution['status'] === 'blocked' ? 'blocked' : 'pending',
                    'error' => $resolution['error'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('legacy_image_migrations')->upsert(
                $rows,
                ['source_hash'],
                [
                    'prefix',
                    'source_path',
                    'destination_path',
                    'detected_mime',
                    'source_content_type',
                    'resolution_status',
                    'resolved_at',
                    'campaign_id',
                    'entity_id',
                    'status',
                    'error',
                    'updated_at',
                ]
            );
        }, 'owner.entity_id', 'entity_id');
    }

    /**
     * Resolve extensionless objects from their S3 metadata and file signature.
     * The full source is intentionally used for every S3 operation because a
     * query string can be part of the object key.
     *
     * @return array{extension: ?string, detected_mime: ?string, source_content_type: ?string, status: string, error: ?string}
     */
    protected function resolveSource(string $source): array
    {
        $cleanSource = preg_split('/[?#]/', $source, 2)[0];
        $extension = mb_strtolower(pathinfo($cleanSource, PATHINFO_EXTENSION));
        if (preg_match('/^[a-z0-9]{1,10}$/', $extension)) {
            return [
                'extension' => $extension,
                'detected_mime' => null,
                'source_content_type' => null,
                'status' => 'resolved',
                'error' => null,
            ];
        }

        $disk = Storage::disk('s3');
        if (! $disk->exists($source)) {
            return [
                'extension' => null,
                'detected_mime' => null,
                'source_content_type' => null,
                'status' => 'pending',
                'error' => null,
            ];
        }

        $sourceContentType = null;
        try {
            $sourceContentType = $this->normalizeMime($disk->mimeType($source));
            $stream = $disk->readStream($source);
            $byteMime = $this->detectMimeFromBytes($stream);
        } catch (Throwable $e) {
            return [
                'extension' => null,
                'detected_mime' => null,
                'source_content_type' => $sourceContentType,
                'status' => 'blocked',
                'error' => "Unable to read image format for {$source}: {$e->getMessage()}",
            ];
        }

        $metadataMime = $this->supportedMime($sourceContentType);

        if ($metadataMime !== null && $byteMime !== null && $metadataMime !== $byteMime) {
            return [
                'extension' => null,
                'detected_mime' => $byteMime,
                'source_content_type' => $sourceContentType,
                'status' => 'blocked',
                'error' => "Content-Type {$sourceContentType} conflicts with detected format {$byteMime} for {$source}",
            ];
        }

        $mime = $byteMime ?? $metadataMime;
        if ($mime === null) {
            return [
                'extension' => null,
                'detected_mime' => null,
                'source_content_type' => $sourceContentType,
                'status' => 'blocked',
                'error' => "Unable to identify image format for {$source}",
            ];
        }

        return [
            'extension' => $this->mimeExtension($mime),
            'detected_mime' => $mime,
            'source_content_type' => $sourceContentType,
            'status' => 'resolved',
            'error' => null,
        ];
    }

    protected function normalizeMime(?string $mime): ?string
    {
        if ($mime === null || $mime === '') {
            return null;
        }

        return mb_strtolower(trim(explode(';', $mime, 2)[0]));
    }

    protected function supportedMime(?string $mime): ?string
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg', 'image/pjpeg' => 'image/jpeg',
            'image/png', 'image/x-png' => 'image/png',
            'image/gif' => 'image/gif',
            'image/webp' => 'image/webp',
            'image/svg+xml' => 'image/svg+xml',
            default => null,
        };
    }

    protected function mimeExtension(string $mime): string
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg', 'image/pjpeg' => 'jpg',
            'image/png', 'image/x-png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            default => throw new RuntimeException("Unsupported image MIME type: {$mime}"),
        };
    }

    protected function detectMimeFromBytes(mixed $stream): ?string
    {
        if (! is_resource($stream)) {
            return null;
        }

        $bytes = fread($stream, 1024 * 1024) ?: '';
        fclose($stream);

        if (str_starts_with($bytes, "\xFF\xD8\xFF")) {
            return 'image/jpeg';
        }
        if (str_starts_with($bytes, "\x89PNG\x0D\x0A\x1A\x0A")) {
            return 'image/png';
        }
        if (str_starts_with($bytes, 'GIF87a') || str_starts_with($bytes, 'GIF89a')) {
            return 'image/gif';
        }
        if (str_starts_with($bytes, 'RIFF') && mb_substr($bytes, 8, 4) === 'WEBP') {
            return 'image/webp';
        }
        if (preg_match('/^(?:\xEF\xBB\xBF)?\s*(?:<\?xml[^>]*>\s*)?<svg(?:\s|>)/i', $bytes) === 1) {
            return 'image/svg+xml';
        }

        return null;
    }

    protected function owners(string $prefix): Builder
    {
        if ($prefix === 'map_layers/') {
            $owners = DB::table('map_layers')
                ->selectRaw('image_path AS source_path, MIN(id) AS entity_id')
                ->where('image_path', 'like', $prefix . '%')
                ->groupBy('image_path');

            return DB::query()
                ->fromSub($owners, 'owner')
                ->join('map_layers', 'map_layers.id', '=', 'owner.entity_id')
                ->join('maps', 'maps.id', '=', 'map_layers.map_id')
                ->select(['owner.source_path', 'owner.entity_id', 'maps.campaign_id']);
        }

        $owners = DB::table('entities')
            ->selectRaw('image_path AS source_path, MIN(id) AS entity_id')
            ->where('image_path', 'like', $prefix . '%')
            ->groupBy('image_path');

        return DB::query()
            ->fromSub($owners, 'owner')
            ->join('entities', 'entities.id', '=', 'owner.entity_id')
            ->select(['owner.source_path', 'owner.entity_id', 'entities.campaign_id']);
    }

    protected function skipsContentReferences(string $prefix): bool
    {
        return $prefix === 'map_layers/';
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

                    $sources = $this->extractPathSources($value, $prefix);
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

        $attributePattern = '~\b(?:src|href|poster|data-src|data-original|srcset)\s*=\s*(?:([\"\'])(.*?)\1|([^\s>]+))~isu';
        preg_match_all($attributePattern, $value, $attributes, PREG_SET_ORDER);
        foreach ($attributes as $attribute) {
            $attributeValue = html_entity_decode($attribute[2] ?? $attribute[3] ?? '', ENT_QUOTES | ENT_HTML5);
            foreach (preg_split('/\s*,\s*|\s+(?=\d+(?:\.\d+)?[wx](?:\s|$))/', $attributeValue) as $candidate) {
                $candidate = preg_replace('/\s+\d+(?:\.\d+)?[wx]$/', '', mb_trim($candidate));
                $this->addUrlSource($sources, (string) $candidate, $prefix);
            }
        }

        $cssPattern = '~url\(\s*([\"\']?)(.*?)\1\s*\)~isu';
        preg_match_all($cssPattern, $value, $cssUrls, PREG_SET_ORDER);
        foreach ($cssUrls as $cssUrl) {
            $this->addUrlSource($sources, html_entity_decode($cssUrl[2], ENT_QUOTES | ENT_HTML5), $prefix);
        }

        return array_keys($sources);
    }

    /** @return list<string> */
    protected function extractPathSources(string $value, string $prefix): array
    {
        $sources = $this->extractSources($value, $prefix);
        $pattern = '~(?<![a-zA-Z0-9_.-])/?(' . preg_quote($prefix, '~') . '[^\s\"\'<>?#)]+)~u';
        preg_match_all($pattern, $value, $matches);

        return array_values(array_unique(array_merge($sources, $matches[1])));
    }

    /** @param array<string, bool> $sources */
    protected function addUrlSource(array &$sources, string $url, string $prefix): void
    {
        $thumborHost = parse_url((string) config('thumbor.url'), PHP_URL_HOST);
        $host = parse_url($url, PHP_URL_HOST);
        if (($host === 'th.kanka.io' || ($thumborHost && $host === $thumborHost)) && str_contains($url, '/src/' . $prefix)) {
            $url = mb_substr($url, mb_strpos($url, '/src/' . $prefix) + 5);
        }

        foreach ($this->knownBases() as $base) {
            if (str_starts_with($url, $base . '/')) {
                $url = mb_substr($url, mb_strlen($base) + 1);
                break;
            }
        }

        $url = mb_ltrim($url, '/');
        if (! str_starts_with($url, $prefix)) {
            return;
        }

        $source = preg_split('/[?#]/', $url, 2)[0];
        if ($source !== '') {
            $sources[$source] = true;
        }
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
