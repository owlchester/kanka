<?php

namespace App\Services\Images;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class LegacyImageMigrationService
{
    /**
     * User-authored fields which can contain embedded legacy image URLs.
     *
     * @var array<string, list<string>>
     */
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

    /**
     * Structured paths which must be clear before a prefix can be retired.
     *
     * @var array<string, list<string>>
     */
    public const PATH_COLUMNS = [
        'entities' => ['image_path', 'header_image'],
        'map_layers' => ['image_path'],
        'campaigns' => ['image', 'header_image'],
        'entity_assets' => ['metadata'],
    ];

    /**
     * @return array{rows: int, fields: int}
     */
    public function rewriteReferences(string $source, string $destination): array
    {
        $rows = 0;
        $fields = 0;

        foreach (self::CONTENT_COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                DB::table($table)
                    ->select(['id', $column])
                    ->where($column, 'like', '%' . $source . '%')
                    ->orderBy('id')
                    ->chunkById(500, function ($records) use ($table, $column, $source, $destination, &$rows, &$fields) {
                        foreach ($records as $record) {
                            $current = $record->{$column};
                            if (! is_string($current) || ! str_contains($current, $source)) {
                                continue;
                            }

                            if ($this->containsSignedThumborReference($current, $source)) {
                                throw new RuntimeException("Signed Thumbor reference found in {$table}.{$column} row {$record->id}");
                            }

                            $updated = $this->rewriteValue($current, $source, $destination);
                            if ($updated === $current) {
                                throw new RuntimeException("Unrecognized reference found in {$table}.{$column} row {$record->id}");
                            }
                            if (str_contains($updated, $source)) {
                                throw new RuntimeException("Unresolved reference remains in {$table}.{$column} row {$record->id}");
                            }

                            $affected = DB::table($table)
                                ->where('id', $record->id)
                                ->where($column, $current)
                                ->update([$column => $updated]);

                            if ($affected !== 1) {
                                throw new RuntimeException("Concurrent update detected in {$table}.{$column} row {$record->id}");
                            }

                            $rows++;
                            $fields++;
                        }
                    }, 'id');
            }
        }

        return ['rows' => $rows, 'fields' => $fields];
    }

    public function rewriteValue(string $value, string $source, string $destination): string
    {
        $destinationUrl = rtrim((string) config('cdn.ugc'), '/') . '/' . $destination;
        if (empty(config('cdn.ugc'))) {
            $destinationUrl = Storage::disk('s3')->url($destination);
        }

        $bases = array_filter(array_unique([
            rtrim((string) config('cdn.ugc'), '/'),
            'https://cdn-ugc.kanka.io',
            'https://kanka-user-assets.s3.eu-central-1.amazonaws.com',
        ]));

        foreach ($bases as $base) {
            $value = str_replace($base . '/' . $source, $destinationUrl, $value);
        }

        $pattern = '~(?<before>^|[\s\"\'=(/])' . preg_quote($source, '~') . '(?=$|[?#\s\"\')>])~u';

        return preg_replace_callback(
            $pattern,
            fn (array $matches): string => $matches['before'] . $destination,
            $value
        ) ?? $value;
    }

    /**
     * @return array{structured: int, content: int}
     */
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

        return compact('structured', 'content');
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
