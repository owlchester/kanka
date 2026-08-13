<?php

namespace App\Console\Commands\Migrations;

use App\Services\Images\LegacyImageMigrationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class MigrateLegacyImages extends Command
{
    protected $signature = 'images:migrate-legacy
                            {prefix : Legacy top-level prefix, for example characters}
                            {--limit=1000 : Maximum distinct source objects to process}
                            {--index : Inventory sources and scan content references once}
                            {--rebuild-index : Replace the existing reference index}
                            {--execute : Copy files, update indexed references, and delete old objects}';

    protected $description = 'Move legacy entity images into their owning campaign without adding them to gallery storage';

    public function __construct(protected LegacyImageMigrationService $migration)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $prefix = $this->prefix();
        if ($prefix === null) {
            return self::FAILURE;
        }

        if ($this->option('index') || $this->option('rebuild-index')) {
            return $this->index($prefix, (bool) $this->option('rebuild-index'));
        }

        if (! $this->option('execute')) {
            $this->report($prefix);

            return self::SUCCESS;
        }

        if (! $this->migration->isIndexed($prefix)) {
            $this->error("{$prefix} has not been indexed. Run this command with --index first.");

            return self::FAILURE;
        }

        $this->finalizeCutovers($prefix);

        return $this->migrateIndexed($prefix, max(1, min(1000, (int) $this->option('limit'))));
    }

    protected function index(string $prefix, bool $rebuild): int
    {
        $this->info("Indexing owned images and content references for {$prefix}...");

        try {
            $result = $this->migration->index($prefix, $rebuild);
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        $this->table(['Metric', 'Count'], [
            ['Owned source images', $result['sources']],
            ['Indexed content references', $result['references']],
            ['Blocked source images', $result['source_blockers']],
            ['Blocking references', $result['blockers']],
        ]);

        return ($result['blockers'] + $result['source_blockers']) === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function migrateIndexed(string $prefix, int $limit): int
    {
        $migrations = DB::table('legacy_image_migrations')
            ->where('prefix', $prefix)
            ->where(function ($query) {
                $query->whereIn('status', ['pending', 'copied'])
                    ->orWhere(function ($query) {
                        $query->where('status', 'complete')
                            ->whereExists(function ($references) {
                                $references->selectRaw('1')
                                    ->from('legacy_image_migration_references')
                                    ->whereColumn('legacy_image_migration_references.legacy_image_migration_id', 'legacy_image_migrations.id')
                                    ->where('legacy_image_migration_references.status', 'pending');
                            });
                    });
            })
            ->orderBy('entity_id')
            ->limit($limit)
            ->get();
        $this->info("Migrating {$migrations->count()} indexed {$prefix} objects.");

        $migrated = 0;
        $skipped = 0;

        foreach ($migrations as $migration) {
            try {
                $this->migrate($migration);
                $migrated++;
            } catch (Throwable $e) {
                $skipped++;
                $this->error("Skipped {$migration->source_path}: {$e->getMessage()}");
                DB::table('legacy_image_migrations')->where('id', $migration->id)->update([
                    'error' => $e->getMessage(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Migrated this run', $migrated],
            ['Skipped this run', $skipped],
            ['Pending owned images', $this->pendingCount($prefix)],
            ['Blocking references', $this->blockerCount($prefix)],
        ]);

        return $skipped === 0 && $this->blockerCount($prefix) === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function migrate(object $migration): void
    {
        if ($migration->status === 'blocked' || $migration->resolution_status === 'blocked') {
            throw new RuntimeException($migration->error ?? 'Image format could not be resolved.');
        }

        if ($migration->destination_path === null) {
            throw new RuntimeException('Image destination is not resolved yet.');
        }

        if ($this->migration->hasBlockers((int) $migration->id)) {
            throw new RuntimeException('This image has blocking indexed references.');
        }

        if ($migration->status !== 'complete') {
            $this->copy($migration);
        }

        DB::transaction(function () use ($migration) {
            $this->migration->rewriteIndexedReferences(
                (int) $migration->id,
                $migration->source_path,
                $migration->destination_path
            );

            DB::table('entities')
                ->where('image_path', $migration->source_path)
                ->update(['image_path' => $migration->destination_path]);

            if ($migration->status !== 'complete') {
                DB::table('legacy_image_migrations')->where('id', $migration->id)->update([
                    'status' => 'cutover',
                    'error' => null,
                    'updated_at' => now(),
                ]);
            }
        });

        if ($migration->status !== 'complete') {
            $this->deleteSource($migration->id, $migration->source_path, $migration->destination_path);
            $this->line("Migrated {$migration->source_path} to {$migration->destination_path}");
        } else {
            $this->line("Repaired indexed references for {$migration->source_path}");
        }
    }

    protected function copy(object $migration): void
    {
        $disk = Storage::disk('s3');
        if (! $disk->exists($migration->source_path)) {
            throw new RuntimeException("Source object is missing: {$migration->source_path}");
        }

        $sourceSize = $disk->size($migration->source_path);
        if (! $disk->exists($migration->destination_path)) {
            $copied = false;
            if ($migration->detected_mime !== null && $migration->detected_mime !== $migration->source_content_type) {
                $copied = $disk->put(
                    $migration->destination_path,
                    $disk->get($migration->source_path),
                    ['ContentType' => $migration->detected_mime]
                );
            } else {
                $copied = $disk->copy($migration->source_path, $migration->destination_path);
            }

            if (! $copied) {
                throw new RuntimeException("Copy failed: {$migration->source_path}");
            }
        }

        if ($disk->size($migration->destination_path) !== $sourceSize) {
            throw new RuntimeException("Destination size does not match source: {$migration->source_path}");
        }

        DB::table('legacy_image_migrations')->where('id', $migration->id)->update([
            'size' => $sourceSize,
            'status' => 'copied',
            'error' => null,
            'updated_at' => now(),
        ]);
    }

    protected function finalizeCutovers(string $prefix): void
    {
        DB::table('legacy_image_migrations')
            ->where('prefix', $prefix)
            ->where('status', 'cutover')
            ->orderBy('id')
            ->each(function ($migration) {
                $this->deleteSource($migration->id, $migration->source_path, $migration->destination_path);
            });
    }

    protected function deleteSource(mixed $id, string $source, string $destination): void
    {
        $disk = Storage::disk('s3');
        if (! $disk->exists($destination)) {
            throw new RuntimeException('Verified destination is missing before source deletion.');
        }

        if ($disk->exists($source) && ! $disk->delete($source)) {
            throw new RuntimeException('Could not delete the source object.');
        }

        DB::table('legacy_image_migrations')->where('id', $id)->update([
            'status' => 'complete',
            'error' => null,
            'updated_at' => now(),
        ]);
    }

    protected function report(string $prefix): void
    {
        $index = DB::table('legacy_image_migration_indexes')->where('prefix', $prefix)->first();

        if (! $index) {
            $owned = DB::table('entities')
                ->where('image_path', 'like', $prefix . '%')
                ->distinct()
                ->count('image_path');
            $this->table(['Metric', 'Value'], [
                ['Index status', 'NOT INDEXED'],
                ['Owned source images', $owned],
                ['Next step', 'Run with --index before --execute'],
            ]);

            return;
        }

        $this->table(['Metric', 'Value'], [
            ['Index status', mb_strtoupper($index->status)],
            ['Indexed source images', $index->source_count],
            ['Indexed content references', $index->reference_count],
            ['Blocking references', $this->blockerCount($prefix)],
            ['Blocked source images', DB::table('legacy_image_migrations')->where('prefix', $prefix)->where('status', 'blocked')->count()],
            ['Pending owned images', $this->pendingCount($prefix)],
            ['Completed images', DB::table('legacy_image_migrations')->where('prefix', $prefix)->where('status', 'complete')->count()],
            ['Indexed at', $index->indexed_at ?? 'never'],
            [
                'Index-safe to delete residual prefix objects as orphans',
                $this->pendingCount($prefix) === 0 && $this->blockerCount($prefix) === 0 ? 'YES' : 'NO',
            ],
        ]);
    }

    protected function pendingCount(string $prefix): int
    {
        return DB::table('legacy_image_migrations')
            ->where('prefix', $prefix)
            ->whereIn('status', ['pending', 'copied', 'cutover'])
            ->count();
    }

    protected function blockerCount(string $prefix): int
    {
        return DB::table('legacy_image_migration_references')
            ->where('prefix', $prefix)
            ->where('status', 'blocker')
            ->count() + DB::table('legacy_image_migrations')
            ->where('prefix', $prefix)
            ->where('status', 'blocked')
            ->count();
    }

    protected function prefix(): ?string
    {
        $prefix = trim((string) $this->argument('prefix'), '/');
        if (! preg_match('/^[a-z0-9-]+$/', $prefix)) {
            $this->error('The prefix may only contain lowercase letters, numbers, and dashes.');

            return null;
        }

        return $prefix . '/';
    }
}
