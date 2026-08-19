<?php

namespace App\Console\Commands\Images;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use JsonException;
use RuntimeException;
use Throwable;

class ExportLegacyDuplicateImages extends Command
{
    protected $signature = 'images:export-legacy-duplicates
                            {--path= : Path to write on the backup disk}';

    protected $description = 'Export entities that still reference a legacy image path';

    public function handle(): int
    {
        $path = $this->option('path') ?: 'legacy-entity-images/unmigrated-' . now()->format('Ymd-His') . '.json';
        $temporaryPath = tempnam(sys_get_temp_dir(), 'kanka-legacy-images-');

        if ($temporaryPath === false) {
            $this->error('Could not create a temporary export file.');

            return self::FAILURE;
        }

        try {
            $count = $this->writeExport($temporaryPath);
            $stream = fopen($temporaryPath, 'r');
            if ($stream === false) {
                throw new RuntimeException('Could not open the temporary export file.');
            }

            try {
                if (! Storage::disk('backup')->writeStream($path, $stream)) {
                    throw new RuntimeException('The backup disk rejected the export.');
                }
            } finally {
                fclose($stream);
            }

            $this->info("Exported {$count} entities to backup:{$path}");

            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('Could not export legacy entity images: ' . $exception->getMessage());

            return self::FAILURE;
        } finally {
            @unlink($temporaryPath);
        }
    }

    /** @throws JsonException */
    protected function writeExport(string $path): int
    {
        $stream = fopen($path, 'w');
        if ($stream === false) {
            throw new RuntimeException('Could not write the temporary export file.');
        }

        $count = 0;

        try {
            fwrite($stream, "{\n    \"version\": 1,\n    \"generated_at\": " . json_encode(now()->toIso8601String(), JSON_THROW_ON_ERROR) . ",\n    \"entities\": [");

            DB::table('entities')
                ->select(['id', 'image_path'])
                ->whereNotNull('image_path')
                ->where('image_path', '!=', '')
                ->where('image_path', 'not like', 'w/%')
                ->where('image_path', 'not like', 'campaigns/%')
                ->orderBy('id')
                ->lazyById(1000)
                ->each(function (object $entity) use ($stream, &$count) {
                    fwrite($stream, ($count === 0 ? "\n" : ",\n") . '        ' . json_encode([
                        'id' => (int) $entity->id,
                        'image_path' => $entity->image_path,
                    ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES));
                    $count++;
                });

            fwrite($stream, ($count === 0 ? '' : "\n    ") . "]\n}\n");
        } finally {
            fclose($stream);
        }

        return $count;
    }
}
