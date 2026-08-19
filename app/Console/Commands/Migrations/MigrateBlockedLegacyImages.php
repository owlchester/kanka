<?php

namespace App\Console\Commands\Migrations;

use App\Services\Images\LegacyImageMigrationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class MigrateBlockedLegacyImages extends Command
{
    protected $signature = 'images:migrate-blocked-legacy
                            {prefix : Legacy top-level prefix, for example characters}
                            {--limit=1000 : Maximum distinct source objects to process}
                            {--execute : Rewrite signed URLs, copy files, and update entity paths}';

    protected $description = 'Migrate legacy images blocked only by signed Thumbor references';

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
        if (! $this->migration->isIndexed($prefix)) {
            $this->error("{$prefix} has not been indexed. Run images:migrate-legacy with --index first.");

            return self::FAILURE;
        }

        if ($this->option('execute')) {
            $this->finalizeCutovers($prefix);
        }

        $migrations = DB::table('legacy_image_migrations')
            ->where('prefix', $prefix)
            ->whereExists(function ($references) {
                $references->selectRaw('1')
                    ->from('legacy_image_migration_references')
                    ->whereColumn('legacy_image_migration_references.legacy_image_migration_id', 'legacy_image_migrations.id')
                    ->where('legacy_image_migration_references.status', 'blocker')
                    ->where('legacy_image_migration_references.error', 'like', 'Signed Thumbor reference%');
            })
            ->orderBy('entity_id')
            ->limit(max(1, min(50000, (int) $this->option('limit'))))
            ->get();

        $this->info("Found {$migrations->count()} {$prefix} images blocked by signed Thumbor references.");
        $migrated = 0;
        $skipped = 0;

        foreach ($migrations as $migration) {
            $signedReferences = $this->signedReferenceCount((int) $migration->id);
            $this->line("{$migration->source_path}: {$signedReferences} signed reference(s)");

            if (! $this->option('execute')) {
                continue;
            }

            try {
                $this->migrate($migration);
                $migrated++;
            } catch (Throwable $exception) {
                $skipped++;
                $this->error("Skipped {$migration->source_path}: {$exception->getMessage()}");
                DB::table('legacy_image_migrations')->where('id', $migration->id)->update([
                    'error' => $exception->getMessage(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Candidates', $migrations->count()],
            ['Migrated', $migrated],
            ['Skipped', $skipped],
            ['Unowned blockers left untouched', $this->unownedBlockerCount($prefix)],
        ]);

        return $skipped === 0 ? self::SUCCESS : self::FAILURE;
    }

    protected function migrate(object $migration): void
    {
        if ($migration->status === 'blocked' || $migration->resolution_status === 'blocked') {
            throw new RuntimeException($migration->error ?? 'Image format could not be resolved.');
        }
        if ($migration->destination_path === null) {
            throw new RuntimeException('Image destination is not resolved yet.');
        }
        if ($this->hasOtherBlockers((int) $migration->id)) {
            throw new RuntimeException('This image also has non-Thumbor blocking references.');
        }

        if ($migration->status !== 'complete') {
            $this->copy($migration);
        }

        DB::transaction(function () use ($migration) {
            $rewritten = $this->migration->rewriteSignedThumborReferences(
                (int) $migration->id,
                $migration->source_path,
                $migration->destination_path
            );
            if ($rewritten === 0) {
                throw new RuntimeException('No signed Thumbor references were rewritten.');
            }

            $this->migration->rewriteIndexedReferences(
                (int) $migration->id,
                $migration->source_path,
                $migration->destination_path
            );

            $ownerTable = $migration->prefix === 'map_layers/' ? 'map_layers' : 'entities';
            DB::table($ownerTable)
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

    protected function hasOtherBlockers(int $migrationId): bool
    {
        return DB::table('legacy_image_migration_references')
            ->where('legacy_image_migration_id', $migrationId)
            ->where('status', 'blocker')
            ->where(function ($query) {
                $query->whereNull('error')
                    ->orWhere('error', 'not like', 'Signed Thumbor reference%');
            })
            ->exists();
    }

    protected function signedReferenceCount(int $migrationId): int
    {
        return DB::table('legacy_image_migration_references')
            ->where('legacy_image_migration_id', $migrationId)
            ->where('status', 'blocker')
            ->where('error', 'like', 'Signed Thumbor reference%')
            ->count();
    }

    protected function unownedBlockerCount(string $prefix): int
    {
        return DB::table('legacy_image_migration_references')
            ->where('prefix', $prefix)
            ->where('status', 'blocker')
            ->whereNull('legacy_image_migration_id')
            ->where('error', 'like', 'No owning entity%')
            ->count();
    }

    protected function prefix(): ?string
    {
        $prefix = trim((string) $this->argument('prefix'), '/');
        if (! preg_match('/^[a-z0-9_-]+$/', $prefix)) {
            $this->error('The prefix may only contain lowercase letters, numbers, dashes, and underscores.');

            return null;
        }

        return $prefix . '/';
    }
}
