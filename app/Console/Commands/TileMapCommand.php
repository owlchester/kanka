<?php

namespace App\Console\Commands;

use App\Models\Map;
use App\Services\Maps\TilingTriggerService;
use Illuminate\Console\Command;

class TileMapCommand extends Command
{
    protected $signature = 'maps:tile {map : The ID of the map to tile}';

    protected $description = "Manually trigger tiling for a map's gallery-backed base image";

    public function handle(TilingTriggerService $trigger): int
    {
        $map = Map::find($this->argument('map'));
        if (! $map) {
            $this->error('Map not found.');

            return self::FAILURE;
        }

        $image = $map->entity->image;
        if (! $image) {
            $this->error('This map has no gallery-backed image to tile (legacy image_path maps are not supported).');

            return self::FAILURE;
        }

        $triggered = $trigger->maybeTrigger($image, force: true);
        if (! $triggered) {
            $this->info('Tiling not triggered (already tiled, running, or errored).');

            return self::SUCCESS;
        }

        $this->info('Tiling job dispatched for image ' . $image->id . '.');

        return self::SUCCESS;
    }
}
