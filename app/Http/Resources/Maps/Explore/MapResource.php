<?php

namespace App\Http\Resources\Maps\Explore;

use App\Facades\Avatar;
use App\Models\Map;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Map $resource
 */
class MapResource extends JsonResource
{
    use CampaignAware;

    public function toArray(Request $request): array
    {
        $map = $this->resource;
        $isChunked = $map->isChunked() && $map->chunkingReady();

        return [
            'id' => $map->id,
            'name' => $map->name,
            'is_real' => $map->isReal(),
            'is_chunked' => $isChunked,
            'has_clustering' => $map->isClustered(),
            'image' => $map->isReal() ? null : Avatar::entity($map->entity)->original(),
            'width' => (int) ($map->width ?: 1000),
            'height' => (int) ($map->height ?: 1000),
            'min_zoom' => $map->minZoom(),
            'max_zoom' => $map->maxZoom(),
            'initial_zoom' => $map->initialZoom(),
            'center' => array_map('floatval', explode(', ', $map->centerFocus())),
            'tile_url' => $map->isReal() ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : null,
            'chunks_url' => $isChunked
                ? route('maps.chunks', [$this->campaign->id, $map->id]) . '/?z={z}&x={x}&y={y}'
                : null,
        ];
    }
}
