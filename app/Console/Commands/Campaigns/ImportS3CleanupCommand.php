<?php

namespace App\Console\Commands\Campaigns;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportS3CleanupCommand extends Command
{
    protected $signature = 'campaigns:import-s3-cleanup';

    protected $description = 'Delete orphaned import files on S3 older than one week';

    public function handle(): void
    {
        $cutoff = now()->subWeek()->getTimestamp();
        $deleted = 0;

        $files = Storage::disk('export')->listContents('campaigns', true);

        foreach ($files as $file) {
            if ($file['type'] !== 'file') {
                continue;
            }

            if (! str_contains($file['path'], '/imports/')) {
                continue;
            }

            if (($file['lastModified'] ?? PHP_INT_MAX) > $cutoff) {
                continue;
            }

            Storage::disk('export')->delete($file['path']);
            $deleted++;
        }

        $this->info("Deleted {$deleted} orphaned import file(s) from S3.");
    }
}
