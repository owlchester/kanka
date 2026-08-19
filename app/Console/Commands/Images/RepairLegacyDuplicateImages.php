<?php

namespace App\Console\Commands\Images;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Throwable;

class RepairLegacyDuplicateImages extends Command
{
    protected $signature = 'images:repair-legacy-duplicates
                            {input : Local repair mapping file}
                            {--execute : Copy images and update entities}';

    protected $description = 'Copy migrated entity images to fresh campaign paths for legacy duplicates';

    public function handle(): int
    {
        try {
            $repairs = $this->repairs($this->readJson((string) $this->argument('input')));
        } catch (Throwable $exception) {
            $this->error('Could not read repair mapping: ' . $exception->getMessage());

            return self::FAILURE;
        }

        $execute = (bool) $this->option('execute');
        $disk = Storage::disk('s3');
        $repaired = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($repairs as $repair) {
            try {
                $target = DB::table('entities')->select(['id', 'campaign_id', 'image_path'])->find($repair['entity_id']);
                $source = DB::table('entities')->select(['id', 'campaign_id', 'image_path'])->find($repair['source_entity_id']);

                if ($target === null || $source === null) {
                    throw new RuntimeException('The target or source entity no longer exists.');
                }
                if ($target->id === $source->id) {
                    throw new RuntimeException('The target and source entity are the same.');
                }
                if ($target->image_path !== $repair['old_image_path']) {
                    $skipped++;
                    $this->warn("Skipped {$target->id}: its image path has changed.");

                    continue;
                }
                if (! is_string($source->image_path) || ! Str::startsWith($source->image_path, ['w/', 'campaigns/'])) {
                    throw new RuntimeException('The source entity does not have a migrated image path.');
                }

                $destination = $this->destination((int) $target->campaign_id, (int) $target->id, $source->image_path);
                $this->line("{$target->id}: {$source->image_path} -> {$destination}");

                if (! $execute) {
                    continue;
                }
                if (! $disk->exists($source->image_path)) {
                    throw new RuntimeException("Source object is missing: {$source->image_path}");
                }

                $sourceSize = $disk->size($source->image_path);
                if ($disk->exists($destination)) {
                    if ($disk->size($destination) !== $sourceSize) {
                        throw new RuntimeException("Destination exists with a different size: {$destination}");
                    }
                } elseif (! $disk->copy($source->image_path, $destination)) {
                    throw new RuntimeException("Copy failed: {$source->image_path}");
                }

                if (! $disk->exists($destination) || $disk->size($destination) !== $sourceSize) {
                    throw new RuntimeException("Could not verify destination: {$destination}");
                }

                $updated = DB::table('entities')
                    ->where('id', $target->id)
                    ->where('image_path', $repair['old_image_path'])
                    ->update(['image_path' => $destination]);

                if ($updated !== 1) {
                    throw new RuntimeException('The entity changed before it could be updated.');
                }

                $repaired++;
            } catch (Throwable $exception) {
                $failed++;
                $this->error("Failed {$repair['entity_id']}: {$exception->getMessage()}");
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Candidates', count($repairs)],
            ['Repaired', $repaired],
            ['Skipped stale records', $skipped],
            ['Failures', $failed],
        ]);

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function destination(int $campaignId, int $entityId, string $source): string
    {
        $cleanSource = preg_split('/[?#]/', $source, 2)[0];
        $extension = mb_strtolower(pathinfo($cleanSource, PATHINFO_EXTENSION));
        if (! preg_match('/^[a-z0-9]{1,10}$/', $extension)) {
            throw new RuntimeException("Could not determine the image extension for {$source}");
        }

        $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, "kanka:legacy-image-duplicate:{$entityId}:{$source}")->toString();

        return "w/{$campaignId}/legacy/{$uuid}.{$extension}";
    }

    /** @return array<string, mixed> */
    protected function readJson(string $path): array
    {
        $contents = @file_get_contents($path);
        if ($contents === false) {
            throw new RuntimeException("Could not read {$path}");
        }

        $data = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        if (! is_array($data) || ($data['version'] ?? null) !== 1) {
            throw new RuntimeException('Unsupported repair mapping format.');
        }

        return $data;
    }

    /** @return list<array{entity_id: int, source_entity_id: int, old_image_path: string}> */
    protected function repairs(array $mapping): array
    {
        if (! isset($mapping['repairs']) || ! is_array($mapping['repairs'])) {
            throw new RuntimeException('The mapping does not contain a repairs array.');
        }

        $repairs = [];
        foreach ($mapping['repairs'] as $repair) {
            if (! is_array($repair)
                || ! is_int($repair['entity_id'] ?? null)
                || ! is_int($repair['source_entity_id'] ?? null)
                || ! is_string($repair['old_image_path'] ?? null)
                || $repair['old_image_path'] === '') {
                throw new RuntimeException('The mapping contains an invalid repair record.');
            }
            $repairs[] = $repair;
        }

        return $repairs;
    }
}
