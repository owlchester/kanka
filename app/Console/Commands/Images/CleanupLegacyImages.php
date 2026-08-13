<?php

namespace App\Console\Commands\Images;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CleanupLegacyImages extends Command
{
    protected const int BATCH_SIZE = 1000;

    protected $signature = 'images:cleanup-legacy {--limit=1000 : Maximum number of legacy images to clear}';

    protected $description = 'Delete legacy entity image paths from S3 while keeping gallery image UUIDs';

    public function handle(): int
    {
        $limit = max(1, (int) $this->option('limit'));
        $disk = Storage::disk('s3');
        $cleared = 0;
        $failed = 0;

        $entities = DB::table('entities')
            ->select(['id', 'image_path'])
            ->whereNotNull('image_path')
            ->whereNotNull('image_uuid')
            ->orderBy('id')
            ->limit($limit)
            ->get();

        foreach ($entities->chunkById(self::BATCH_SIZE) as $batch) {
            $paths = $batch->pluck('image_path')->all();

            try {
                if (! $disk->delete($paths)) {
                    $failed += $batch->count();
                    $this->warn('Could not delete a batch of legacy image paths.');

                    continue;
                }
            } catch (Throwable $exception) {
                $failed += $batch->count();
                $this->warn("Could not delete a batch of legacy image paths: {$exception->getMessage()}");

                continue;
            }

            $updated = DB::table('entities')
                ->whereIn('id', $batch->pluck('id'))
                ->whereNotNull('image_uuid')
                ->update(['image_path' => null]);

            $cleared += $updated;
        }

        $this->info("Cleared {$cleared} legacy image(s).");

        if ($failed > 0) {
            $this->warn("Failed to clear {$failed} legacy image(s).");
        }

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
