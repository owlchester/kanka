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
     * Generate a Leaflet-servable ("google" layout: {z}/{y}/{x}.jpg or .png) tile pyramid for the
     * given image via the `vips` CLI (libvips-tools), honoring the image's native aspect ratio (no
     * padding to square). `vips` can only read/write real local filesystem paths — the source is
     * downloaded to a local temp file and the generated tiles are uploaded back to the configured
     * disk (which may be S3) afterward. Uses `.png` tiles (preserves transparency) when the source
     * image has an alpha channel, `.jpg` (smaller files) otherwise. Writes to
     * {disk}/images/{uuid}/tiles/. Returns the actual zoom range `vips` generated (['min_zoom' =>
     * int, 'max_zoom' => int]) so the caller can persist it onto any map using this image — the old
     * fixed zoom-range assumption bore no relationship to what a given image's pyramid actually
     * contains. Throws on any vips failure — the caller (TileImageJob) is responsible for catching
     * and recording it.
     */
    public function tile(Image $image): array
    {
        $disk = Storage::disk(config('images.disk'));

        $localSource = $this->downloadToLocalTemp($disk, $image->path);
        $localTilesDir = sys_get_temp_dir() . '/kanka-tiling-' . $image->id . '-' . Str::random(8);

        try {
            $suffix = $this->chooseSuffix($localSource);

            $process = new Process($this->command($localSource, $localTilesDir, $suffix));
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
    public function command(string $localSourcePath, string $localTilesDir, string $suffix = '.jpg[Q=85]'): array
    {
        return [
            'vips', 'dzsave',
            $localSourcePath,
            $localTilesDir,
            '--layout=google',
            '--suffix=' . $suffix,
            '--tile-size=256',
            '--overlap=0',
        ];
    }

    /**
     * `.png` preserves transparency (needed for images with an alpha channel); `.jpg` is smaller
     * and used for the common fully-opaque case. `vipsheader -f bands` reports 2 (grayscale+alpha)
     * or 4 (RGBA) for images with an alpha channel, 1 (grayscale) or 3 (RGB) without one.
     */
    protected function chooseSuffix(string $localSourcePath): string
    {
        $process = new Process(['vipsheader', '-f', 'bands', $localSourcePath]);
        $process->mustRun();
        $bands = (int) trim($process->getOutput());

        return in_array($bands, [2, 4], true) ? '.png' : '.jpg[Q=85]';
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
            if (! in_array($file->getExtension(), ['jpg', 'png'], true)) {
                continue;
            }

            $relative = ltrim(Str::after($file->getPathname(), $localTilesDir), '/');

            // `vips dzsave --layout=google` also emits a "blank.png" placeholder icon at the top
            // level of the tiles directory (used internally as a fallback/spacer) — this is not a
            // real tile and must never be uploaded. Real tiles always live nested two levels deep
            // ({z}/{y}/{x}.ext), so a top-level file (no "/" in its relative path) is never a tile.
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
