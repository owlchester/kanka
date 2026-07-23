<?php

namespace App\Services\Maps;

use App\Models\Image;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class TilingService
{
    /**
     * Generate a Leaflet-servable ("google" layout: {z}/{y}/{x}.webp) tile pyramid for the given
     * image via the `vips` CLI (libvips-tools), honoring the image's native aspect ratio (no
     * padding to square). `vips` can only read/write real local filesystem paths — the source is
     * downloaded to a local temp file and the generated tiles are uploaded back to the configured
     * disk (which may be S3) afterward. Always emits `.webp` tiles — it supports alpha (unlike jpg)
     * at file sizes comparable to or smaller than png, so every source format (jpg/png/webp/gif)
     * produces a single, fixed, predictable tile extension with no per-image tracking needed.
     * Writes to {disk}/images/{uuid}/tiles/. Returns the actual zoom range `vips` generated
     * (['min_zoom' => int, 'max_zoom' => int]) so the caller can persist it onto any map using this
     * image — the old fixed zoom-range assumption bore no relationship to what a given image's
     * pyramid actually contains. Throws on any vips failure — the caller (TileImageJob) is
     * responsible for catching and recording it.
     */
    public function tile(Image $image): array
    {
        $disk = Storage::disk(config('images.disk'));

        $localSource = $this->downloadToLocalTemp($disk, $image->path);
        $localTilesDir = sys_get_temp_dir() . '/kanka-tiling-' . $image->id . '-' . Str::random(8);

        try {
            $process = new Process($this->command($localSource, $localTilesDir));
            $process->setTimeout(0);
            $process->mustRun();

            $zoomRange = $this->scanZoomRange($localTilesDir);

            // deleteDirectory() silently no-ops against S3/MinIO-backed disks (the adapter has no
            // real "directory" concept to remove) — delete each existing tile file individually
            // instead, so a re-tile doesn't leave stale tiles from a previous pyramid mixed in.
            $disk->delete($disk->allFiles($image->tilesPath()));
            $this->uploadTiles($disk, $localTilesDir, $image->tilesPath());

            return $zoomRange;
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
    public function command(string $localSourcePath, string $localTilesDir, string $suffix = '.webp[Q=80]'): array
    {
        return [
            'vips', 'dzsave',
            $localSourcePath,
            $localTilesDir,
            '--layout=google',
            '--suffix=' . $suffix,
            '--tile-size=256',
            '--overlap=0',
            // Edge tiles (the last row/col of the pyramid) are smaller than the full tile size and
            // get padded out to 256x256 — vips's default padding is opaque white, which shows as a
            // solid white block over what should be transparent. `0` broadcasts to every band
            // (RGB or RGBA alike), making the padding transparent wherever alpha exists.
            '--background=0',
        ];
    }

    /**
     * Scan the actually-generated local tile directory for its real zoom range, rather than
     * re-deriving a formula — this reflects exactly what `vips` produced for this image, with no
     * risk of an off-by-one mismatch against vips's own internal level-count logic.
     *
     * @return array{min_zoom: int, max_zoom: int}
     */
    protected function scanZoomRange(string $localTilesDir): array
    {
        $levels = [];

        foreach (scandir($localTilesDir) ?: [] as $entry) {
            if (! is_dir($localTilesDir . '/' . $entry) || ! ctype_digit($entry)) {
                continue;
            }

            $levels[] = (int) $entry;
        }

        if (empty($levels)) {
            throw new RuntimeException('vips produced no zoom levels for this image.');
        }

        return ['min_zoom' => min($levels), 'max_zoom' => max($levels)];
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
            if ($file->getExtension() !== 'webp') {
                continue;
            }

            $relative = ltrim(Str::after($file->getPathname(), $localTilesDir), '/');

            // Real tiles always live nested two levels deep ({z}/{y}/{x}.webp), so a top-level
            // file (no "/" in its relative path) is never a tile.
            if (! str_contains($relative, '/')) {
                continue;
            }

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
