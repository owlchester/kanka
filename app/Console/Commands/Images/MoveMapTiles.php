<?php

namespace App\Console\Commands\Images;

use App\Models\Image;
use Aws\CommandPool;
use Aws\S3\S3Client;
use Illuminate\Console\Command;
use Illuminate\Filesystem\AwsS3V3Adapter;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class MoveMapTiles extends Command
{
    protected $signature = 'images:move-map-tiles
                            {--execute : Move tile directories instead of performing a dry run}
                            {--concurrency=25 : Number of concurrent S3 copy operations}';

    protected $description = 'Move map tile directories into their campaign folders';

    public function handle(): int
    {
        $disk = Storage::disk();
        $execute = (bool) $this->option('execute');
        $concurrency = max(1, min(100, (int) $this->option('concurrency')));
        $failed = false;

        foreach (Image::query()
            ->where('tiling_status', Image::TILING_FINISHED)
            ->select(['id', 'campaign_id'])
            ->cursor() as $image) {
            $sourcePath = $image->legacyTilesPath();
            if (! $disk->directoryExists($sourcePath)) {
                continue;
            }

            $destinationPath = $image->tilesPath();
            if (! $execute) {
                $this->line("Would move {$sourcePath} -> {$destinationPath}");

                continue;
            }

            try {
                $files = $disk instanceof AwsS3V3Adapter
                    ? $this->migrateS3($disk, $sourcePath, $destinationPath, $concurrency)
                    : $this->migrateFilesystem($disk, $sourcePath, $destinationPath);

                $this->line("Migrated image {$image->id} ({$files} files): {$sourcePath} -> {$destinationPath}");
            } catch (Throwable $exception) {
                $this->error("Could not move {$image->id}: {$exception->getMessage()}");
                $failed = true;
            }
        }

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    protected function migrateFilesystem(
        FilesystemAdapter $disk,
        string $sourcePath,
        string $destinationPath
    ): int {
        if ($disk->directoryExists($destinationPath) || $disk->fileExists($destinationPath)) {
            throw new RuntimeException("Destination already exists: {$destinationPath}");
        }

        $sourceFiles = $disk->allFiles($sourcePath);
        if ($sourceFiles === []) {
            throw new RuntimeException("No tiles found in {$sourcePath}");
        }

        foreach ($sourceFiles as $sourceFile) {
            $relativePath = ltrim(substr($sourceFile, strlen($sourcePath)), '/');
            if (! $disk->move($sourceFile, $destinationPath . '/' . $relativePath)) {
                throw new RuntimeException("File move failed: {$sourceFile}");
            }
        }

        $disk->deleteDirectory($sourcePath);

        return count($sourceFiles);
    }

    protected function migrateS3(
        AwsS3V3Adapter $disk,
        string $sourcePath,
        string $destinationPath,
        int $concurrency
    ): int {
        $client = $disk->getClient();
        $config = $disk->getConfig();
        $bucket = $config['bucket'];
        $sourcePrefix = $this->physicalPath($config, $sourcePath) . '/';
        $destinationPrefix = $this->physicalPath($config, $destinationPath) . '/';
        $sources = $this->objects($client, $bucket, $sourcePrefix);

        if ($sources === []) {
            throw new RuntimeException("No tiles found in {$sourcePath}");
        }

        $destinations = $this->objects($client, $bucket, $destinationPrefix);
        $missing = 0;
        foreach ($sources as $relativePath => $source) {
            if (isset($destinations[$relativePath])) {
                if ($destinations[$relativePath]['size'] !== $source['size']) {
                    throw new RuntimeException("Destination conflict: {$destinationPath}/{$relativePath}");
                }

                continue;
            }

            $missing++;
        }

        if ($missing > 0) {
            $this->line("Copying {$missing} tiles with concurrency {$concurrency}...");
            $commands = function () use ($client, $bucket, $sources, $destinations, $destinationPrefix) {
                foreach ($sources as $relativePath => $source) {
                    if (isset($destinations[$relativePath])) {
                        continue;
                    }

                    yield $relativePath => $client->getCommand('CopyObject', [
                        'ACL' => 'public-read',
                        'Bucket' => $bucket,
                        'CopySource' => $bucket . '/' . S3Client::encodeKey($source['key']),
                        'Key' => $destinationPrefix . $relativePath,
                        'MetadataDirective' => 'COPY',
                    ]);
                }
            };
            $copyFailure = null;
            $copied = 0;
            $pool = new CommandPool($client, $commands(), [
                'concurrency' => $concurrency,
                'preserve_iterator_keys' => true,
                'fulfilled' => function () use (&$copied, $missing) {
                    $copied++;
                    if ($copied % 1000 === 0 || $copied === $missing) {
                        $this->line("Copied {$copied}/{$missing} tiles.");
                    }
                },
                'rejected' => function (Throwable $exception, string $relativePath) use (&$copyFailure) {
                    $copyFailure ??= "{$relativePath}: {$exception->getMessage()}";
                },
            ]);
            $pool->promise()->wait();

            if ($copyFailure !== null) {
                throw new RuntimeException("Copy failed for {$sourcePath}/{$copyFailure}");
            }
        }

        $destinations = $this->objects($client, $bucket, $destinationPrefix);
        foreach ($sources as $relativePath => $source) {
            if (! isset($destinations[$relativePath]) || $destinations[$relativePath]['size'] !== $source['size']) {
                throw new RuntimeException("Could not verify {$destinationPath}/{$relativePath}");
            }
        }

        // Flysystem's S3 adapter deletes the prefix with DeleteObjects batches of up to 1,000 keys.
        if (! $disk->deleteDirectory($sourcePath) || $disk->directoryExists($sourcePath)) {
            throw new RuntimeException("Could not delete migrated source {$sourcePath}");
        }

        return count($sources);
    }

    /**
     * @return array<string, array{key: string, size: int}>
     */
    protected function objects(S3Client $client, string $bucket, string $prefix): array
    {
        $objects = [];
        foreach ($client->getPaginator('ListObjectsV2', [
            'Bucket' => $bucket,
            'Prefix' => $prefix,
        ]) as $result) {
            foreach ($result['Contents'] ?? [] as $object) {
                $key = (string) $object['Key'];
                $relativePath = substr($key, strlen($prefix));
                if ($relativePath === '') {
                    continue;
                }

                $objects[$relativePath] = [
                    'key' => $key,
                    'size' => (int) $object['Size'],
                ];
            }
        }

        return $objects;
    }

    /** @param array<string, mixed> $config */
    protected function physicalPath(array $config, string $path): string
    {
        $root = trim((string) ($config['root'] ?? ''), '/');

        return $root === '' ? $path : $root . '/' . $path;
    }
}
