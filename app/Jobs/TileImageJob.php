<?php

namespace App\Jobs;

use App\Events\Maps\TilingChanged;
use App\Models\Image;
use App\Models\Map;
use App\Services\Maps\TilingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class TileImageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(public Image $image)
    {
        $this->onConnection('heavy');
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [30, 60, 120];
    }

    public function handle(TilingService $service): void
    {
        $zoomRange = $service->tile($this->image);

        Image::where('id', $this->image->id)->update([
            'tiling_status' => Image::TILING_FINISHED,
            'tiling_error' => null,
        ]);

        $this->applyZoomRangeToMaps($zoomRange);

        TilingChanged::broadcastForImage($this->image->fresh());
    }

    public function failed(Throwable $e): void
    {
        Image::where('id', $this->image->id)->update([
            'tiling_status' => Image::TILING_ERROR,
            'tiling_error' => $e->getMessage(),
        ]);

        report($e);

        TilingChanged::broadcastForImage($this->image->fresh());
    }

    /**
     * Persist the real, vips-generated zoom range onto every map currently using this image as
     * its base — but only where the map hasn't already been manually configured with its own
     * min/max zoom, so an explicit user setting is never overwritten.
     *
     * @param  array{min_zoom: int, max_zoom: int}  $zoomRange
     */
    protected function applyZoomRangeToMaps(array $zoomRange): void
    {
        Map::whereHas('entity', fn ($query) => $query->where('image_uuid', $this->image->id))
            ->get()
            ->each(function (Map $map) use ($zoomRange) {
                if ($map->min_zoom !== null || $map->max_zoom !== null) {
                    return;
                }

                $map->min_zoom = $zoomRange['min_zoom'];
                $map->max_zoom = $zoomRange['max_zoom'];
                $map->initial_zoom = $zoomRange['min_zoom'];
                $map->saveQuietly();
            });
    }
}
