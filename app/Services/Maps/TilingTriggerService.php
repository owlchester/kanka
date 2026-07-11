<?php

namespace App\Services\Maps;

use App\Jobs\TileImageJob;
use App\Models\Image;

class TilingTriggerService
{
    /**
     * Trigger tiling for an image if it isn't already tiled/running/errored, and it's over the
     * size threshold (unless $force bypasses the threshold — used for the manual migration
     * prompt / artisan command paths). Atomically guards against dispatching the job twice for
     * the same image, even if two maps/layers are assigned the same oversized image concurrently.
     */
    public function maybeTrigger(Image $image, bool $force = false): bool
    {
        if ($image->tiling_status !== null) {
            return false;
        }

        if (! $force && $image->size < config('maps.tiling_threshold_kb')) {
            return false;
        }

        $updated = Image::where('id', $image->id)
            ->whereNull('tiling_status')
            ->update(['tiling_status' => Image::TILING_RUNNING]);

        if (! $updated) {
            return false;
        }

        TileImageJob::dispatch($image);

        return true;
    }
}
