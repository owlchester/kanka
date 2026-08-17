<?php

namespace App\Console\Commands\Images;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MoveMapTiles extends Command
{
    protected $signature = 'images:move-map-tiles
                            {--execute : Move tile directories instead of performing a dry run}';

    protected $description = 'Move map tile directories into their campaign folders';

    public function handle(): int
    {
        $disk = Storage::disk();
        $execute = (bool) $this->option('execute');
        $failed = false;

        foreach (Image::query()
            ->where('tiling_status', Image::TILING_FINISHED)
            ->select(['id', 'campaign_id'])
            ->cursor() as $image) {
            $sourcePath = 'images/' . $image->id . '/tiles';
            $source = $disk->path($sourcePath);
            if (! is_dir($source)) {
                $this->warn("Already moved: {$sourcePath}");
                continue;
            }

            $destinationPath = $image->tilesPath();
            $destination = $disk->path($destinationPath);
            if (! $execute) {
                $this->line("Would move {$sourcePath} -> {$destinationPath}");

                continue;
            }

            if (file_exists($destination)) {
                $this->error("Destination already exists: {$destinationPath}");
                $failed = true;

                continue;
            }

            try {
                File::ensureDirectoryExists(dirname($destination));
                if (! File::moveDirectory($source, $destination)) {
                    throw new \RuntimeException('Directory move failed.');
                }
                $this->line("Migrated image {$image->id}: {$sourcePath} -> {$destinationPath}");
            } catch (Throwable $exception) {
                $this->error("Could not move {$image->id}: {$exception->getMessage()}");
                $failed = true;
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
