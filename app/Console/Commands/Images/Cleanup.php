<?php

namespace App\Console\Commands\Images;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\StorageAttributes;

class Cleanup extends Command
{
    protected $signature = 'images:cleanup
                            {--execute : Move matching images instead of performing a dry run}';

    protected $description = 'Move root campaign images to the deleted campaign image folder';

    /** @var list<string> */
    protected const IMAGE_EXTENSIONS = [
        'avif',
        'bmp',
        'gif',
        'jpeg',
        'jpg',
        'png',
        'svg',
        'tif',
        'tiff',
        'webp',
    ];

    public function handle(): int
    {
        $disk = Storage::disk('s3');
        $matched = 0;
        $moved = 0;
        $conflicts = 0;

        foreach ($disk->getDriver()->listContents('w', false) as $attributes) {
            if (! $this->isRootImage($attributes)) {
                continue;
            }

            $source = $attributes->path();
            $destination = 'w/deleted/' . basename($source);
            $matched++;
            $this->line("{$source} -> {$destination}");

            if (! $this->option('execute')) {
                continue;
            }
            if ($disk->exists($destination)) {
                $conflicts++;
                $this->warn("Destination already exists: {$destination}");

                continue;
            }
            if (! $disk->move($source, $destination)) {
                $this->error("Could not move {$source}");

                continue;
            }

            $moved++;
        }

        $this->table(['Metric', 'Count'], [
            ['Matched', $matched],
            ['Moved', $moved],
            ['Conflicts', $conflicts],
        ]);

        if (! $this->option('execute')) {
            $this->comment('Dry run. Nothing was moved.');
        }

        return $conflicts > 0 ? self::FAILURE : self::SUCCESS;
    }

    protected function isRootImage(StorageAttributes $attributes): bool
    {
        if (! $attributes->isFile()) {
            return false;
        }

        $path = $attributes->path();
        if (! str_starts_with($path, 'w/')) {
            return false;
        }

        $filename = substr($path, strlen('w/'));
        if ($filename === '' || str_contains($filename, '/')) {
            return false;
        }

        return in_array(mb_strtolower(pathinfo($filename, PATHINFO_EXTENSION)), self::IMAGE_EXTENSIONS, true);
    }
}
