<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\Map;
use App\Services\Maps\TiledMapCoordinateRepairService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class RepairTiledMapCoordinatesCommand extends Command
{
    protected $signature = 'maps:repair-tiled-coordinates
        {from : Inclusive map creation timestamp, YYYY-MM-DD HH:MM:SS in database timezone}
        {until : Exclusive map creation timestamp, YYYY-MM-DD HH:MM:SS in database timezone}
        {--map=* : Restrict to these map IDs (repeatable)}
        {--execute : Persist the repair; otherwise only report proposed changes}';

    protected $description = 'Repair negative coordinates stored by the original tiled map explorer';

    public function handle(TiledMapCoordinateRepairService $repair): int
    {
        $validator = Validator::make([
            'from' => $this->argument('from'),
            'until' => $this->argument('until'),
            'maps' => $this->option('map'),
        ], [
            'from' => ['required', 'date_format:Y-m-d H:i:s', 'before:until'],
            'until' => ['required', 'date_format:Y-m-d H:i:s'],
            'maps.*' => ['integer', 'min:1'],
        ]);
        if ($validator->fails()) {
            $this->error($validator->errors()->first());

            return self::FAILURE;
        }

        $execute = (bool) $this->option('execute');
        $this->info($execute ? 'Applying coordinate repairs.' : 'Dry run: no database changes.');
        $this->line("Map creation window: [{$this->argument('from')}, {$this->argument('until')}) in database timezone.");
        $candidates = Map::query()
            ->where('is_real', false)
            ->when($this->option('map'), fn ($query, $ids) => $query->whereIn('id', $ids))
            ->whereHas('entity', fn ($query) => $query
                ->where('created_at', '>=', $this->argument('from'))
                ->where('created_at', '<', $this->argument('until'))
                ->whereHas('image', fn ($query) => $query->where('tiling_status', Image::TILING_FINISHED)))
            ->where(fn ($query) => $query->where('center_y', '<', 0)
                ->orWhereHas('markers', fn ($query) => $query->withoutGlobalScopes()->where('latitude', '<', 0)));

        $maps = $markers = $centers = $failed = 0;
        foreach ($candidates->lazyById(100) as $map) {
            try {
                $result = $repair->repair($map->id, $execute);
            } catch (Throwable $exception) {
                $failed++;
                $this->error("Map {$map->id}: skipped entire map: {$exception->getMessage()}");

                continue;
            }
            $count = count($result['markers']);
            $hasCenter = $result['center'] !== [];
            $maps++;
            $markers += $count;
            $centers += (int) $hasCenter;
            $this->line("Map {$map->id} (campaign {$map->campaign_id}): {$count} markers, " . (int) $hasCenter . " saved center; scale {$result['scale']}.");
            foreach ($result['markers'] as $id => $attributes) {
                $this->line("  Marker {$id}: [{$attributes['latitude']}, {$attributes['longitude']}]", verbosity: OutputInterface::VERBOSITY_VERBOSE);
            }
        }

        $this->table(['Metric', $execute ? 'Repaired' : 'Proposed'], [
            ['Maps', $maps], ['Markers', $markers], ['Saved centers', $centers], ['Failed maps (unchanged)', $failed],
        ]);
        if (! $execute) {
            $this->comment('Dry run complete. Add --execute to persist these changes.');
        }

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }
}
