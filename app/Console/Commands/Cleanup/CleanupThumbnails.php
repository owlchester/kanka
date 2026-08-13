<?php

namespace App\Console\Commands\Cleanup;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use League\Flysystem\FileAttributes;
use League\Flysystem\StorageAttributes;

class CleanupThumbnails extends Command
{
    protected $signature = 'cleanup:thumbnails
                            {prefix : S3 prefix to scan, for example calendars}
                            {--execute : Delete matching files instead of performing a dry run}
                            {--max-size= : Only match files no larger than this size, for example 5kb}';

    protected $description = 'Delete legacy thumbnail files from S3';

    /** @var list<string> */
    protected array $matches = [];

    protected int $matchedCount = 0;

    protected int $totalBytes = 0;

    public function handle(): int
    {
        try {
            $maxSize = $this->parseSize($this->option('max-size'));
        } catch (InvalidArgumentException $exception) {
            $this->error($exception->getMessage());

            return self::INVALID;
        }

        $prefix = trim((string) $this->argument('prefix'), '/');
        $disk = Storage::disk('s3');

        foreach ($disk->getDriver()->listContents($prefix, true) as $attributes) {
            if (! $this->matches($attributes, $maxSize)) {
                continue;
            }

            $this->matches[] = $attributes->path();
            $this->matchedCount++;
            $this->totalBytes += $attributes instanceof FileAttributes ? $attributes->fileSize() ?? 0 : 0;

            if (count($this->matches) === 1000) {
                $this->flushMatches($disk);
            }
        }

        $this->flushMatches($disk);

        $action = $this->option('execute') ? 'Deleted' : 'Matched';
        $this->info("{$action}: " . number_format($this->matchedCount) . ' files');
        $this->info('Total size: ' . $this->formatBytes($this->totalBytes));

        if (! $this->option('execute')) {
            $this->comment('Dry run. Nothing was deleted.');
        }

        return self::SUCCESS;
    }

    protected function matches(StorageAttributes $attributes, ?int $maxSize): bool
    {
        if (! $attributes->isFile()) {
            return false;
        }

        $path = mb_strtolower($attributes->path());
        $suffixes = ['_thumb.png', '_thumb.jpg', '_thumb.jpeg'];
        $matchesSuffix = false;
        foreach ($suffixes as $suffix) {
            if (str_ends_with($path, $suffix)) {
                $matchesSuffix = true;
                break;
            }
        }
        if (! $matchesSuffix) {
            return false;
        }

        $size = $attributes instanceof FileAttributes ? $attributes->fileSize() ?? 0 : 0;

        return $maxSize === null || $size <= $maxSize;
    }

    protected function flushMatches(mixed $disk): void
    {
        if ($this->matches === []) {
            return;
        }

        if ($this->option('execute')) {
            $disk->delete($this->matches);
        }

        $this->matches = [];
    }

    protected function parseSize(?string $value): ?int
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        if (! preg_match('/^(\d+(?:\.\d+)?)\s*(b|kb|mb|gb)?$/i', trim($value), $matches)) {
            throw new InvalidArgumentException('The --max-size value must look like 500b, 5kb, 2mb, or 1gb.');
        }

        $size = (float) $matches[1];
        $multiplier = match (mb_strtolower($matches[2] ?? 'b')) {
            'kb' => 1024,
            'mb' => 1024 ** 2,
            'gb' => 1024 ** 3,
            default => 1,
        };

        return (int) ceil($size * $multiplier);
    }

    protected function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes . ' B';
        }

        if ($bytes < 1024 ** 2) {
            return round($bytes / 1024, 2) . ' KB';
        }

        if ($bytes < 1024 ** 3) {
            return round($bytes / (1024 ** 2), 2) . ' MB';
        }

        return round($bytes / (1024 ** 3), 2) . ' GB';
    }
}
