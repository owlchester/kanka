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
    protected $signature = 'cleanup:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old images from s3';

    protected int $count = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directories = Storage::directories('w/');
        $chunks = array_chunk($directories, 200);
        foreach ($chunks as $chunk) {
            $ids = [];
            foreach ($chunk as $path) {
                $ids[] = Str::after($path, 'w/');
            }
            $select = "SELECT id FROM campaigns WHERE id in (?)";
            $db = DB::select($select, [implode(',', $ids)]);
            foreach ($db as $existingId) {
                unset($ids[array_search($existingId->id, $ids)]);
            }

            if (empty($ids)) {
                continue;
            }
            foreach ($ids as $id) {
                if (empty($id)) {
                    continue;
                }
                Storage::deleteDirectory('w/' . $id);
                $this->count++;
            }
        }

        $this->info('Deleted ' . $this->count . ' images/folders.');
    }
}
