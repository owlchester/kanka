<?php

namespace App\Console\Commands\Images;

use App\Models\Map;
use App\Models\MapLayer;
use App\Services\Images\LegacyImageMigrationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Throwable;

class MigrateMapLayers extends Command
{
    protected $signature = 'images:migrate-map-layers
                            {--execute : Move files and update map layer paths}';

    protected $description = 'Move legacy map layer images into their campaign folders';

    public function __construct(protected LegacyImageMigrationService $migration)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $execute = (bool) $this->option('execute');
        $disk = Storage::disk('s3');
        $mapLayerTable = (new MapLayer)->getTable();
        $mapTable = (new Map)->getTable();
        $stats = [
            'candidates' => 0,
            'migrated' => 0,
            'missing' => 0,
            'unresolved' => 0,
            'conflicts' => 0,
            'failed' => 0,
        ];

        $layers = DB::table($mapLayerTable)
            ->join($mapTable, "{$mapTable}.id", '=', "{$mapLayerTable}.map_id")
            ->select([
                "{$mapLayerTable}.id as layer_id",
                "{$mapLayerTable}.image_path",
                "{$mapTable}.campaign_id",
            ])
            ->whereNotNull("{$mapLayerTable}.image_path")
            ->where("{$mapLayerTable}.image_path", 'not like', 'w/%/legacy/map_layers/%')
            ->lazyById(500, "{$mapLayerTable}.id", 'layer_id');

        foreach ($layers as $layer) {
            $stats['candidates']++;
            $source = ltrim((string) $layer->image_path, '/');

            if (! $disk->exists($source)) {
                $stats['missing']++;
                $this->warn("Layer {$layer->layer_id}: source does not exist: {$source}");

                continue;
            }

            try {
                $extension = $this->migration->resolveExtension($source);
            } catch (Throwable $exception) {
                $stats['unresolved']++;
                $this->warn("Layer {$layer->layer_id}: {$exception->getMessage()}");

                continue;
            }

            $destination = $this->destination(
                (int) $layer->campaign_id,
                (int) $layer->layer_id,
                $source,
                $extension,
            );
            $this->line("{$layer->layer_id}: {$source} -> {$destination}");

            if (! $execute) {
                continue;
            }
            if ($disk->exists($destination)) {
                $stats['conflicts']++;
                $this->warn("Layer {$layer->layer_id}: destination already exists: {$destination}");

                continue;
            }

            $moved = false;

            try {
                if (! $disk->move($source, $destination)) {
                    throw new RuntimeException('Move failed.');
                }
                $moved = true;
                if (! $disk->exists($destination)) {
                    throw new RuntimeException('Destination could not be verified after the move.');
                }

                $updated = DB::table($mapLayerTable)
                    ->where('id', $layer->layer_id)
                    ->where('image_path', $layer->image_path)
                    ->update(['image_path' => $destination]);

                if ($updated !== 1) {
                    if (! $disk->move($destination, $source)) {
                        throw new RuntimeException('The layer changed and the S3 move could not be rolled back.');
                    }
                    $moved = false;

                    throw new RuntimeException('The layer changed before its image path could be updated.');
                }

                $stats['migrated']++;
            } catch (Throwable $exception) {
                if ($moved && $disk->exists($destination) && ! $disk->exists($source)) {
                    $disk->move($destination, $source);
                }

                $stats['failed']++;
                $this->error("Layer {$layer->layer_id}: {$exception->getMessage()}");
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Candidates', $stats['candidates']],
            ['Migrated', $stats['migrated']],
            ['Missing sources', $stats['missing']],
            ['Unresolved extensions', $stats['unresolved']],
            ['Destination conflicts', $stats['conflicts']],
            ['Failures', $stats['failed']],
        ]);

        if (! $execute) {
            $this->comment('Dry run. Nothing was moved.');
        }

        return $stats['failed'] === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function destination(int $campaignId, int $layerId, string $source, string $extension): string
    {
        $uuid = Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            "kanka:legacy-map-layer:{$campaignId}:{$layerId}:{$source}",
        )->toString();

        return "w/{$campaignId}/legacy/map_layers/{$uuid}.{$extension}";
    }
}
