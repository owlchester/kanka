<?php

namespace App\Console\Commands;

use App\Models\Location;
use App\Models\MapPoint;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateLocationPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:point';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Location Map Points to entities';

    protected $points = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = new MapPoint();
        $model->with('location', 'location.entity')->chunk(500, function ($mapPoints) {
            foreach ($mapPoints as $mapPoint) {

                if (!empty($mapPoint->target)) {
                    $this->points++;
                    $mapPoint->target_entity_id = $mapPoint->target->entity->id;
                    $mapPoint->save();
                }
            }
        });


        $this->info("Updated " . $this->points . " map points.");
    }
}
