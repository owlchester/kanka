<?php

namespace App\Console\Commands\Migrations;

use App\Models\Image;
use App\Models\MapLayer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class MapLayersToGallery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:map-layers-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate map layers to use the gallery';

    protected int $count = 0;

    protected ProgressBar $bar;

    protected Image $image;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $now = Carbon::now();
        $total = MapLayer::count();
        $this->info($now->format('H:i:s') . ': Preparing to migrate up to ' . $total . ' entities.');
        $this->bar = $this->output->createProgressBar($total);
        $this->bar->start();

        MapLayer::with('campaign')->chunkById(500, function ($layers) {
            foreach ($layers as $layer) {
                $this->migrate($layer);
            }
        });

        $this->bar->finish();
        $this->info('');
        $this->info($now->format('H:i:s') . ': Migrated ' . $this->count . ' map layers to the gallery.');
    }

    protected function migrate(MapLayer $layer): void
    {
        $this->bar->advance();

        // Get the file from s3
        $path = $layer->getAttribute('image');
        dd($file);

        $this->image = new Image();
        $this->image->id = Str::uuid()->toString();
        $this->image->campaign_id = $layer->map->campaign_id;
        $this->image->created_by = $layer->created_by;
        $this->image->name = Str::beforeLast($file->getClientOriginalName(), '.');
        $this->image->ext = Str::before($file->extension(), '?');
        $this->image->size = (int) ceil(Storage::fileSize($path) / 1024); // kb
        $this->image->visibility_id = $layer->visibility_id;
        $this->image->save();

        $file->storePubliclyAs($this->image->folder, $this->image->file);
        $this->count++;
    }
}
