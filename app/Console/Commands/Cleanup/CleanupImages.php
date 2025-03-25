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
    protected $signature = 'cleanup:images {folder=w} {max=500} {dry=0}';

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
    public function handle()
    {
        $folder = $this->argument('folder');
        $this->max = (int) $this->argument('max');

        $dry = $this->argument('dry');
        if ($dry === '1') {
            $this->dry = false;
        }

        $this->info('Cleaning up ' . $folder);
        if ($this->dry) {
            $this->warn('This is a dry run. Nothing will get deleted.');
        }
        $directories = Storage::directories($folder . '/');
        $chunks = array_chunk($directories, 500);
        foreach ($chunks as $chunk) {
            $ids = [];
            foreach ($chunk as $path) {
                $ids[] = Str::after($path, $folder . '/');
            }

            // Get ids where a left join on the campaigns table has no result
            $select = 'with u(id) as (values (' . implode('), (', $ids) . ')) ' .
                'select u.id from u ' .
                'left join campaigns as c on c.id = u.id ' .
                'where c.id is null';
            $db = DB::select($select);
            $nullCampaigns = [];
            foreach ($db as $campaign) {
                $nullCampaigns[] = $campaign->id;
            }

            if (empty($nullCampaigns)) {
                continue;
            }
            foreach ($nullCampaigns as $id) {
                if (empty($id)) {
                    continue;
                }
                if (! $this->dry) {
                    Storage::deleteDirectory($folder . '/' . $id);
                }
                $this->count++;
            }
            if ($this->dry) {
                $this->info(implode(',', $nullCampaigns));
            }
            if ($this->count > $this->max) {
                $this->info('Reached max amount of ' . $this->max);

                return;
            }
        }

        if ($this->dry) {
            return;
        }
        $this->info('Deleted ' . $this->count . ' images/folders.');
    }
}
