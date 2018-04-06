<?php

namespace App\Console\Commands;

use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateLocationMaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:map';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the location map points';

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
     *
     * @return mixed
     */
    public function handle()
    {
        $points = 0;

        $mapPoints = MapPoint::with('location')->get();
        $locations = [];
        foreach ($mapPoints as $mapPoint) {
            if (empty($locations[$mapPoint->location_id])) {
                $img = $mapPoint->location->map;
                $size = getimagesize(Storage::disk('public')->path($img));
                $locations[$mapPoint->location_id] = [
                    'image' => $img,
                    'width' => $size[0],
                    'height' => $size[1],
                ];
            }
        }

        foreach ($mapPoints as $mapPoint) {
            $points++;
            // Convert the current proportions from % to px
            $loc = $locations[$mapPoint->location_id];
            $ratio = 900 / $loc['width'];
            $mapPoint->axis_y = $loc['height'] * ($mapPoint->axis_y / 100) + 10;
            $mapPoint->axis_x = $loc['width'] * ($mapPoint->axis_x / 100) + 10;
            $mapPoint->save();

        }

        $this->info("Fixed $points points");
    }
}
