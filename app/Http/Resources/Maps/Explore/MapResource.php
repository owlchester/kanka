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
            'has_clustering' => (bool) $map->isClustered(),
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
            'create_url' => route('entities.map-markers.store', [$this->campaign->id, $map->entity->id]),
            'search_url' => route('search.entities-with-relations', $this->campaign->id),
            'has_distance_unit' => $map->hasDistanceUnit(),
            'distance_measure' => $map->config['distance_measure'] ?? null,
            'distance_name' => $map->config['distance_name'] ?? 'Km',
            'settings' => [
                'grid' => $map->grid ? (int) $map->grid : null,
                'min_zoom' => $map->min_zoom ? (int) $map->min_zoom : null,
                'max_zoom' => $map->max_zoom ? (int) $map->max_zoom : null,
                'initial_zoom' => $map->initial_zoom ? (int) $map->initial_zoom : null,
                'distance_measure' => $map->config['distance_measure'] ?? null,
                'distance_name' => $map->config['distance_name'] ?? null,
                'center_x' => $map->center_x !== null ? (float) $map->center_x : null,
                'center_y' => $map->center_y !== null ? (float) $map->center_y : null,
                'center_marker_id' => $map->center_marker_id,
            ],
            'settings_url' => route('entities.map-settings.update', [$this->campaign->id, $map->entity->id]),
            'show_url' => route('entities.show', [$this->campaign->id, $map->entity->id]),
            'edit_url' => route('entities.edit', [$this->campaign->id, $map->entity->id]),
        ];
    }
}
