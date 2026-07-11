<?php

namespace App\Services\Maps;

use App\Models\Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class TilingService
{
    /**
     * Generate a Leaflet-servable ("google" layout: {z}/{x}/{y}.jpg) tile pyramid for the given
     * image via the `vips` CLI (libvips-tools), honoring the image's native aspect ratio (no
     * padding to square). Writes to {disk}/images/{uuid}/tiles/. Throws on any vips failure —
     * the caller (TileImageJob) is responsible for catching and recording it.
     */
    public function tile(Image $image): void
    {
        $disk = Storage::disk(config('images.disk'));

        $disk->deleteDirectory($image->tilesPath());
        $disk->makeDirectory($image->tilesPath());

        $process = new Process($this->command($image, $disk));
        $process->setTimeout(0);
        $process->mustRun();
    }

    /**
     * @return string[]
     */
    public function command(Image $image, Filesystem $disk): array
    {
        return [
            'vips', 'dzsave',
            $disk->path($image->path),
            $disk->path($image->tilesPath()),
            '--layout=google',
            '--suffix=.jpg[Q=85]',
            '--tile-size=256',
            '--overlap=0',
        ];
    }
}
