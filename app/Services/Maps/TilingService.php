<?php

namespace App\Services\Maps;

use App\Models\Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class TilingService
{
    /**
     * Generate a Leaflet-servable ("google" layout: {z}/{x}/{y}.jpg) tile pyramid for the given
     * image via the `vips` CLI (libvips-tools), honoring the image's native aspect ratio (no
     * padding to square). `vips` can only read/write real local filesystem paths — the source
     * is downloaded to a local temp file and the generated tiles are uploaded back to the
     * configured disk (which may be S3) afterward, since that disk may not be local at all.
     * Writes to {disk}/images/{uuid}/tiles/. Throws on any vips failure — the caller
     * (TileImageJob) is responsible for catching and recording it.
     */
    public function tile(Image $image): void
    {
        $disk = Storage::disk(config('images.disk'));

        $localSource = $this->downloadToLocalTemp($disk, $image->path);
        $localTilesDir = sys_get_temp_dir() . '/kanka-tiling-' . $image->id . '-' . Str::random(8);

        try {
            $process = new Process($this->command($localSource, $localTilesDir));
            $process->setTimeout(0);
            $process->mustRun();

            $disk->deleteDirectory($image->tilesPath());
            $this->uploadTiles($disk, $localTilesDir, $image->tilesPath());
        } finally {
            @unlink($localSource);
            $this->deleteLocalDirectory($localTilesDir);
        }
    }

    /**
     * Pure command-argument builder — no Storage/Process side effects — so it can be
     * unit-tested without mocking Process or having `vips` installed.
     *
     * @return string[]
     */
    public function command(string $localSourcePath, string $localTilesDir): array
    {
        return [
            'vips', 'dzsave',
            $localSourcePath,
            $localTilesDir,
            '--layout=google',
            '--suffix=.jpg[Q=85]',
            '--tile-size=256',
            '--overlap=0',
        ];
    }

    protected function downloadToLocalTemp(Filesystem $disk, string $diskPath): string
    {
        $localPath = sys_get_temp_dir() . '/' . Str::random(12) . '-' . basename($diskPath);
        file_put_contents($localPath, $disk->get($diskPath));

        return $localPath;
    }

    protected function uploadTiles(Filesystem $disk, string $localTilesDir, string $diskPrefix): void
    {
        if (! is_dir($localTilesDir)) {
            return;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($localTilesDir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            if ($file->getExtension() !== 'jpg') {
                continue;
            }

            $relative = ltrim(Str::after($file->getPathname(), $localTilesDir), '/');
            $disk->put($diskPrefix . '/' . $relative, file_get_contents($file->getPathname()));
        }
    }

    protected function deleteLocalDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
        }

        rmdir($path);
    }
}
