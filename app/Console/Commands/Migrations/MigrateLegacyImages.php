<?php

namespace App\Console\Commands\Migrations;

use App\Services\Images\LegacyImageMigrationService;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Throwable;

class MigrateLegacyImages extends Command
{
    protected $signature = 'images:migrate-legacy
                            {prefix : Legacy top-level prefix, for example characters}
                            {--limit=1000 : Maximum distinct source objects to process}
                            {--execute : Copy files, update references, and delete old objects}';

    protected $description = 'Move legacy entity images into their owning campaign without adding them to gallery storage';

    public function __construct(protected LegacyImageMigrationService $migration)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $prefix = trim((string) $this->argument('prefix'), '/');
        $limit = max(1, min(1000, (int) $this->option('limit')));
        $execute = (bool) $this->option('execute');

        if (! preg_match('/^[a-z0-9-]+$/', $prefix)) {
            $this->error('The prefix may only contain lowercase letters, numbers, and dashes.');

            return self::FAILURE;
        }

        $prefix .= '/';
        $this->finalizeCutovers($prefix, $execute);

        $owners = $this->owners($prefix, $limit)->get();
        $this->info(($execute ? 'Migrating' : 'Dry run for') . " {$owners->count()} distinct {$prefix} objects.");

        $migrated = 0;
        $skipped = 0;
        $lastId = 0;

        if (! $execute) {
            foreach ($owners as $owner) {
                $lastId = max($lastId, (int) $owner->entity_id);
                $this->line("Would migrate {$owner->source_path} to campaign {$owner->campaign_id} (owner entity {$owner->entity_id})");
            }
        } else {
            foreach ($owners as $owner) {
                try {
                    $this->migrate($owner);
                    $migrated++;
                } catch (Throwable $e) {
                    $skipped++;
                    $this->error("Skipped {$owner->source_path}: {$e->getMessage()}");
                    DB::table('legacy_image_migrations')
                        ->where('source_hash', hash('sha256', $owner->source_path))
                        ->update(['error' => $e->getMessage(), 'updated_at' => now()]);
                }
            }
        }

        foreach ($owners as $owner) {
            $lastId = max($lastId, (int) $owner->entity_id);
        }

        $remaining = $this->migration->remainingReferences($prefix);
        $safe = $remaining['structured'] === 0 && $remaining['content'] === 0 && $skipped === 0;

        $this->newLine();
        $this->table(['Metric', 'Count'], [
            ['Migrated this run', $migrated],
            ['Skipped this run', $skipped],
            ['Remaining structured references', $remaining['structured']],
            ['Remaining content references', $remaining['content']],
            ['Last owner entity ID', $lastId],
        ]);
        $this->line('Database-safe to delete remaining prefix objects as orphans: ' . ($safe ? 'YES' : 'NO'));

        return $skipped === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function owners(string $prefix, int $limit): Builder
    {
        $owners = DB::table('entities')
            ->selectRaw('image_path AS source_path, MIN(id) AS entity_id')
            ->where('image_path', 'like', $prefix . '%')
            ->groupBy('image_path');

        return DB::query()
            ->fromSub($owners, 'owners')
            ->join('entities', 'entities.id', '=', 'owners.entity_id')
            ->orderBy('owners.entity_id')
            ->limit($limit)
            ->select(['owners.source_path', 'owners.entity_id', 'entities.campaign_id']);
    }

    protected function migrate(object $owner): void
    {
        [$source, $destination] = $this->copy($owner);

        DB::transaction(function () use ($source, $destination) {
            $this->migration->rewriteReferences($source, $destination);

            DB::table('entities')
                ->where('image_path', $source)
                ->update(['image_path' => $destination]);

            DB::table('legacy_image_migrations')->where('source_hash', hash('sha256', $source))->update([
                'status' => 'cutover',
                'updated_at' => now(),
            ]);
        });

        $this->deleteSource($source, $destination);
        $this->line("Migrated {$source} to {$destination}");
    }

    /**
     * @return array{string, string}
     */
    protected function copy(object $owner): array
    {
        $source = (string) $owner->source_path;
        $extension = mb_strtolower(pathinfo($source, PATHINFO_EXTENSION));
        if (! preg_match('/^[a-z0-9]{1,10}$/', $extension)) {
            throw new \RuntimeException('The source has an invalid extension.');
        }

        $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, "kanka:legacy-image:{$owner->campaign_id}:{$source}")->toString();
        $destination = "w/{$owner->campaign_id}/legacy/{$uuid}.{$extension}";
        $disk = Storage::disk('s3');

        $sourceHash = hash('sha256', $source);
        $createdAt = DB::table('legacy_image_migrations')
            ->where('source_hash', $sourceHash)
            ->value('created_at') ?? now();
        DB::table('legacy_image_migrations')->updateOrInsert(
            ['source_hash' => $sourceHash],
            [
                'source_path' => $source,
                'destination_path' => $destination,
                'campaign_id' => $owner->campaign_id,
                'entity_id' => $owner->entity_id,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]
        );

        if (! $disk->exists($source)) {
            throw new \RuntimeException("Source object is missing: {$source}");
        }

        $sourceSize = $disk->size($source);
        if (! $disk->exists($destination)) {
            if (! $disk->copy($source, $destination)) {
                throw new \RuntimeException("Copy failed: {$source}");
            }
        }

        if ($disk->size($destination) !== $sourceSize) {
            throw new \RuntimeException("Destination size does not match source: {$source}");
        }

        DB::table('legacy_image_migrations')->where('source_hash', $sourceHash)->update([
            'size' => $sourceSize,
            'status' => 'copied',
            'error' => null,
            'updated_at' => now(),
        ]);

        return [$source, $destination];
    }

    protected function finalizeCutovers(string $prefix, bool $execute): void
    {
        if (! $execute) {
            return;
        }

        DB::table('legacy_image_migrations')
            ->where('status', 'cutover')
            ->where('source_path', 'like', $prefix . '%')
            ->orderBy('id')
            ->each(function ($migration) {
                $this->deleteSource($migration->source_path, $migration->destination_path);
            });
    }

    protected function deleteSource(string $source, string $destination): void
    {
        $disk = Storage::disk('s3');
        if (! $disk->exists($destination)) {
            throw new \RuntimeException('Verified destination is missing before source deletion.');
        }

        if ($disk->exists($source) && ! $disk->delete($source)) {
            throw new \RuntimeException('Could not delete the source object.');
        }

        DB::table('legacy_image_migrations')->where('source_hash', hash('sha256', $source))->update([
            'status' => 'complete',
            'error' => null,
            'updated_at' => now(),
        ]);
    }
}
