<?php

namespace App\Console\Commands\Images;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class MoveMapTiles extends Command
{
    protected $signature = 'images:move-map-tiles
                            {--execute : Move the legacy tile files instead of only reporting them}';

    protected $description = 'Move map tiles into their campaign image folders';

    /**
     * Move legacy image-keyed tile pyramids into their campaign-scoped paths.
     */
    public function handle(): int
    {
        $disk = Storage::disk();
        $execute = (bool) $this->option('execute');
        $stats = [
            'folders' => 0,
            'files' => 0,
            'moved' => 0,
            'missing' => 0,
            'conflicts' => 0,
            'failed' => 0,
        ];
        $legacyFiles = $this->legacyFiles($disk);

        if (! $execute) {
            $this->warn('This is a dry run. Nothing will be moved.');
        }

        foreach ($legacyFiles as $imageId => $files) {
            $image = Image::query()->find($imageId);
            $source = 'images/' . $imageId . '/tiles';

            if (! $image) {
                $stats['missing']++;
                $this->warn("No image record found for {$source}.");

                continue;
            }

            $destination = $image->tilesPath();
            $stats['folders']++;
            $stats['files'] += count($files);
            $this->line(sprintf('%s: %d file(s) %s -> %s', $imageId, count($files), $source, $destination));

            if (! $execute) {
                continue;
            }

            if ($this->hasConflicts($disk, $files, $source, $destination)) {
                $stats['conflicts']++;
                $this->warn("Destination conflict for {$source}; no files were moved.");

                continue;
            }

            try {
                foreach ($files as $file) {
                    $target = $this->destinationFile($file, $source, $destination);
                    if (! $disk->move($file, $target)) {
                        throw new \RuntimeException("Move failed for {$file}.");
                    }

                    $stats['moved']++;
                }

                if ($disk->allFiles($source) === []) {
                    $disk->deleteDirectory($source);
                }
            } catch (Throwable $exception) {
                $stats['failed']++;
                $this->warn("Could not move {$source}: {$exception->getMessage()}");
            }
        }

        $this->table(['Metric', 'Count'], [
            ['Tile folders', $stats['folders']],
            ['Tile files', $stats['files']],
            ['Moved files', $stats['moved']],
            ['Missing images', $stats['missing']],
            ['Destination conflicts', $stats['conflicts']],
            ['Failures', $stats['failed']],
        ]);

        if (! $execute) {
            return self::SUCCESS;
        }

        return $stats['missing'] + $stats['conflicts'] + $stats['failed'] > 0
            ? self::FAILURE
            : self::SUCCESS;
    }

    /**
     * @return array<string, array<int, string>>
     */
    protected function legacyFiles(Filesystem $disk): array
    {
        $files = [];

        foreach ($disk->allFiles('images') as $file) {
            $file = trim($file, '/');
            if (! preg_match('#^images/([^/]+)/tiles/.+$#', $file, $matches)) {
                continue;
            }

            $files[$matches[1]][] = $file;
        }

        return $files;
    }

    /**
     * Check all destinations before moving anything so a conflict does not create a partial
     * migration for one image.
     *
     * @param  array<int, string>  $files
     */
    protected function hasConflicts(Filesystem $disk, array $files, string $source, string $destination): bool
    {
        foreach ($files as $file) {
            if ($disk->exists($this->destinationFile($file, $source, $destination))) {
                return true;
            }
        }

        return false;
    }

    protected function destinationFile(string $file, string $source, string $destination): string
    {
        return $destination . '/' . Str::after($file, $source . '/');
    }
}
