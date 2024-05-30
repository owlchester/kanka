<?php

namespace App\Console\Commands\Migrations;

use App\Models\Entity;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class MigrateImageFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:image-folder {dry=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move old entity images from their entity name folder to the campaign folder';

    protected int $count = 0;

    protected ProgressBar $bar;

    protected bool $dry;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->dry = (bool) $this->argument('dry');
        if ($this->dry) {
            $this->warn('This is a dry run, no data will be modified.');
        } else {
            $conf = $this->confirm('This is a real run, data will be modified. Are you sure?');
            if (!$conf) {
                return;
            }
        }
        $total = Entity::select(['id'])
            ->whereNotNull('image_path')
            ->where('image_path', 'not like', 'w/%')
            ->count();

        $now = Carbon::now();
        $this->info($now->format('H:i:s') . ': Preparing to migrate up to ' . $total . ' entities.');
        $this->bar = $this->output->createProgressBar($total);
        $this->bar->start();
        Entity::select(['id', 'campaign_id', 'image_path'])
            ->whereNotNull('image_path')
            ->where('image_path', 'not like', 'w/%')
            ->chunk(5000, function ($entities) {
                foreach ($entities as $entity) {
                    $this->move($entity);
                }
            });
        $this->bar->finish();
        $this->info('');
        $this->info($now->format('H:i:s') . ': Migrated ' . $this->count . ' entities.');
    }

    protected function move(Entity $entity): void
    {
        $this->bar->advance();
        // If the image is already in the w/ dir, don't do anything
        if (Str::startsWith($entity->image_path, 'w/')) {
            return;
        }
        $this->count++;

        if ($this->dry) {
            return;
        }
        $newPath = 'w/' . $entity->campaign_id . '/' . Str::afterLast($entity->image_path, '/');
        Storage::move($entity->image_path, $newPath);
        $entity->image_path = $newPath;
        $entity->saveQuietly();
    }
}
