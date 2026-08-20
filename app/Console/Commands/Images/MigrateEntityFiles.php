<?php

namespace App\Console\Commands\Images;

use App\Enums\EntityAssetType;
use App\Models\Entity;
use App\Models\EntityAsset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Symfony\Component\Mime\MimeTypes;
use Throwable;

class MigrateEntityFiles extends Command
{
    protected $signature = 'images:migrate-entity-files
                            {--execute : Move files and update entity asset metadata}';

    protected $description = 'Move legacy entity files into their campaign folders';

    public function handle(): int
    {
        $execute = (bool) $this->option('execute');
        $disk = Storage::disk('s3');
        $assetTable = (new EntityAsset)->getTable();
        $entityTable = (new Entity)->getTable();
        $stats = [
            'candidates' => 0,
            'migrated' => 0,
            'missing' => 0,
            'malformed' => 0,
            'unresolved' => 0,
            'conflicts' => 0,
            'failed' => 0,
        ];

        $assets = DB::table($assetTable)
            ->join($entityTable, "{$entityTable}.id", '=', "{$assetTable}.entity_id")
            ->select([
                "{$assetTable}.id as asset_id",
                "{$assetTable}.metadata",
                "{$entityTable}.campaign_id",
            ])
            ->where("{$assetTable}.type_id", EntityAssetType::file->value)
            ->whereNotNull("{$assetTable}.metadata")
            ->lazyById(500, "{$assetTable}.id", 'asset_id');

        foreach ($assets as $asset) {
            try {
                $metadata = json_decode((string) $asset->metadata, true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $exception) {
                $stats['malformed']++;
                $this->warn("Asset {$asset->asset_id}: invalid metadata: {$exception->getMessage()}");

                continue;
            }

            if (! is_array($metadata)) {
                $stats['malformed']++;
                $this->warn("Asset {$asset->asset_id}: metadata is not a JSON object.");

                continue;
            }

            $source = $metadata['path'] ?? null;
            if (! is_string($source) || ! Str::startsWith($source, 'entities/files/')) {
                continue;
            }

            $stats['candidates']++;
            if (! $disk->exists($source)) {
                $stats['missing']++;
                $this->warn("Asset {$asset->asset_id}: source does not exist: {$source}");

                continue;
            }

            try {
                $extension = $this->extension($source, $metadata['type'] ?? null);
            } catch (Throwable $exception) {
                $stats['unresolved']++;
                $this->warn("Asset {$asset->asset_id}: {$exception->getMessage()}");

                continue;
            }

            $destination = $this->destination(
                (int) $asset->campaign_id,
                (int) $asset->asset_id,
                $source,
                $extension,
            );
            $this->line("{$asset->asset_id}: {$source} -> {$destination}");

            if (! $execute) {
                continue;
            }
            if ($disk->exists($destination)) {
                $stats['conflicts']++;
                $this->warn("Asset {$asset->asset_id}: destination already exists: {$destination}");

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

                $metadata['path'] = $destination;
                $updated = DB::table($assetTable)
                    ->where('id', $asset->asset_id)
                    ->where('metadata', $asset->metadata)
                    ->update([
                        'metadata' => json_encode($metadata, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
                    ]);

                if ($updated !== 1) {
                    if (! $disk->move($destination, $source)) {
                        throw new RuntimeException('The asset changed and the S3 move could not be rolled back.');
                    }
                    $moved = false;

                    throw new RuntimeException('The asset changed before its metadata could be updated.');
                }

                $stats['migrated']++;
            } catch (Throwable $exception) {
                if ($moved && $disk->exists($destination) && ! $disk->exists($source)) {
                    $disk->move($destination, $source);
                }

                $stats['failed']++;
                $this->error("Asset {$asset->asset_id}: {$exception->getMessage()}");
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Candidates', $stats['candidates']],
            ['Migrated', $stats['migrated']],
            ['Missing sources', $stats['missing']],
            ['Malformed metadata', $stats['malformed']],
            ['Unresolved extensions', $stats['unresolved']],
            ['Destination conflicts', $stats['conflicts']],
            ['Failures', $stats['failed']],
        ]);

        if (! $execute) {
            $this->comment('Dry run. Nothing was moved.');
        }

        return $stats['failed'] === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function extension(string $source, mixed $type): string
    {
        $cleanSource = preg_split('/[?#]/', $source, 2)[0];
        $extension = mb_strtolower(pathinfo($cleanSource, PATHINFO_EXTENSION));

        if (preg_match('/^[a-z0-9]{1,10}$/', $extension)) {
            return $extension;
        }
        if (! is_string($type) || $type === '') {
            throw new RuntimeException("Could not determine the file extension for {$source}");
        }

        $mime = mb_strtolower(trim(explode(';', $type, 2)[0]));
        $extensions = MimeTypes::getDefault()->getExtensions($mime);
        $extension = $extensions[0] ?? null;

        if (! is_string($extension) || ! preg_match('/^[a-z0-9]{1,10}$/', $extension)) {
            throw new RuntimeException("Unsupported MIME type {$type} for {$source}");
        }

        return $extension;
    }

    protected function destination(int $campaignId, int $assetId, string $source, string $extension): string
    {
        $uuid = Uuid::uuid5(
            Uuid::NAMESPACE_URL,
            "kanka:legacy-entity-file:{$campaignId}:{$assetId}:{$source}",
        )->toString();

        return "w/{$campaignId}/legacy/entities/files/{$uuid}.{$extension}";
    }
}
