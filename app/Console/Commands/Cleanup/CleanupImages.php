<?php

namespace App\Console\Commands\Cleanup;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CleanupImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:images
                            {--folder=w : Folder prefix to cleanup}
                            {--max=500 : Maximum number of folders deleted}
                            {--execute : Execute the cleanup}';

    protected bool $dry = true;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old images from s3';

    protected int $count = 0;

    protected int $max = 0;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $folder = trim((string) $this->option('folder'), '/');
        $max = filter_var($this->option('max'), FILTER_VALIDATE_INT);
        if ($max === false || $max < 1) {
            $this->error('The --max option must be a positive integer.');

            return self::INVALID;
        }
        $this->max = $max;

        if ($this->option('execute')) {
            $this->dry = false;
        }

        $this->info('Cleaning up ' . $folder . '/');
        if ($this->dry) {
            $this->warn('This is a dry run. Nothing will get deleted.');
        }
        $directories = Storage::directories($folder . '/');
        $skipped = 0;
        $chunks = array_chunk($directories, 500);
        foreach ($chunks as $chunk) {
            if ($this->count >= $this->max) {
                break;
            }

            $candidates = [];
            foreach ($chunk as $path) {
                $id = Str::after($path, $folder . '/');
                $campaignId = filter_var($id, FILTER_VALIDATE_INT, [
                    'options' => ['min_range' => 1],
                ]);

                if (! ctype_digit($id) || $campaignId === false) {
                    $skipped++;

                    continue;
                }

                $candidates[] = [
                    'id' => $campaignId,
                    'path' => $path,
                ];
            }

            if ($candidates === []) {
                continue;
            }

            $ids = array_column($candidates, 'id');
            $existingIds = DB::table('campaigns')
                ->whereIn('id', $ids)
                ->pluck('id')
                ->map(static fn ($id): int => (int) $id)
                ->all();
            $existingIds = array_fill_keys($existingIds, true);

            $nullCampaigns = array_values(array_filter(
                $candidates,
                static fn (array $candidate): bool => ! isset($existingIds[$candidate['id']]),
            ));
            if ($nullCampaigns === []) {
                continue;
            }

            $remaining = $this->max - $this->count;
            $nullCampaigns = array_slice($nullCampaigns, 0, $remaining);
            foreach ($nullCampaigns as $campaign) {
                if (! $this->dry) {
                    $files = Storage::allFiles($campaign['path']);
                    if (! empty($files)) {
                        Storage::delete($files);
                    }
                    Storage::deleteDirectory($campaign['path']);
                }
                $this->count++;
            }
            if ($this->dry) {
                $this->info('Would delete ' . $this->count . ' images/folders.');
                $this->info(implode(',', array_column($nullCampaigns, 'id')));
            }
            if ($this->count >= $this->max) {
                $this->info('Reached max amount of ' . $this->max);

                break;
            }
        }

        if ($skipped > 0) {
            $this->warn("Skipped {$skipped} non-numeric folder(s).");
        }

        if ($this->dry) {
            return self::SUCCESS;
        }
        $this->info('Deleted ' . $this->count . ' images/folders.');

        return self::SUCCESS;
    }
}
