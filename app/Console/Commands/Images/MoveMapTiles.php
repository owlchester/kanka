<?php

namespace App\Console\Commands\Images;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Throwable;

class MoveMapTiles extends Command
{
    protected $signature = 'images:move-map-tiles';

    protected $description = 'Move map tile directories into their campaign folders';

    public function handle(): int
    {
        $disk = Storage::disk();
        $failed = false;

        foreach (Image::query()->select(['id', 'campaign_id'])->cursor() as $image) {
            $source = $disk->path('images/' . $image->id . '/tiles');
            if (! is_dir($source)) {
                continue;
            }

            $destination = $disk->path($image->tilesPath());
            if (file_exists($destination)) {
                $this->error("Destination already exists: {$image->tilesPath()}");
                $failed = true;

                continue;
            }

            try {
                File::ensureDirectoryExists(dirname($destination));
                if (! File::moveDirectory($source, $destination)) {
                    throw new \RuntimeException('Directory move failed.');
                }
            } catch (Throwable $exception) {
                $this->error("Could not move {$image->id}: {$exception->getMessage()}");
                $failed = true;
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
