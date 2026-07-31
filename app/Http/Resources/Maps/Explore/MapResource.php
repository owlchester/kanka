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
        // Resolves the actual image dimensions and persists them when null (e.g. after an edit
        // reset them, per Map::afterModelSave()) - without this, width/height silently fall back
        // to the 1000x1000 default below, which doesn't match markers placed under the map's real
        // (usually much larger) pixel dimensions and pushes them out of the visible/pannable area.
        $map->prepareBounds();
        $isTiled = $map->isTiled();
        $tiling = $map->tilingRunning() ? 'running' : ($map->tilingError() ? 'error' : null);
        $center = array_map('floatval', explode(', ', $map->centerFocus()));
        $focusPinId = null;

        if ($request->filled('lat') && $request->filled('lng')) {
            $center = [(float) $request->query('lat'), (float) $request->query('lng')];
        } elseif ($request->filled('focus')) {
            $focusId = (int) $request->query('focus');
            $pin = $map->markers->first(fn ($marker) => $marker->id === $focusId && $marker->visible());
            if ($pin) {
                $center = [(float) $pin->latitude, (float) $pin->longitude];
                $focusPinId = $pin->id;
            }
        }

        return [
            'id' => $map->id,
            'name' => $map->name,
            'is_real' => $map->isReal(),
            'is_tiled' => $isTiled,
            'tiling' => $tiling,
            'tiling_prompt_eligible' => $this->tilingPromptEligible(),
            'has_clustering' => (bool) $map->isClustered(),
            'image' => $map->isReal() ? null : Avatar::entity($map->entity)->original(),
            'width' => (int) ($map->width ?: 1000),
            'height' => (int) ($map->height ?: 1000),
            'min_zoom' => $map->minZoom(),
            'max_zoom' => $map->maxZoom(),
            'initial_zoom' => $map->initialZoom(),
            'center' => $center,
            'focus_pin_id' => $focusPinId,
            'tile_url' => $map->isReal() ? 'https://tile.openstreetmap.org/{z}/{x}/{y}.png' : null,
            'tiles_url' => $map->tilesUrl(),
            'create_url' => route('entities.map-markers.store', [$this->campaign->id, $map->entity->id]),
            'preset_store_url' => route('entities.map-presets.store', [$this->campaign->id, $map->entity->id]),
            'group_store_url' => route('entities.map-groups.store', [$this->campaign->id, $map->entity->id]),
            'search_url' => route('search.entities-with-relations', $this->campaign->id),
            'mentions_url' => route('search.mention', [$this->campaign->id]),
            'gallery_url' => route('gallery.tiptap', [$this->campaign->id]),
            'gallery_upload_url' => route('campaign.gallery.ajax-upload', $this->campaign->id),
            'has_distance_unit' => $map->hasDistanceUnit(),
            'distance_measure' => $map->config['distance_measure'] ?? null,
            'distance_name' => $map->config['distance_name'] ?? 'Km',
            'settings' => [
                // grid is coerced to (int) on every save by MapObserver::saving(), so it can
                // never actually be null once persisted; 0 is its "unset" sentinel value.
                'grid' => $map->grid ? (int) $map->grid : null,
                'min_zoom' => $map->min_zoom !== null ? (int) $map->min_zoom : null,
                'max_zoom' => $map->max_zoom !== null ? (int) $map->max_zoom : null,
                'initial_zoom' => $map->initial_zoom !== null ? (int) $map->initial_zoom : null,
                'distance_measure' => $map->config['distance_measure'] ?? null,
                'distance_name' => $map->config['distance_name'] ?? null,
                'center_x' => $map->center_x !== null ? (float) $map->center_x : null,
                'center_y' => $map->center_y !== null ? (float) $map->center_y : null,
                'center_marker_id' => $map->center_marker_id,
                'legacy_pins' => (bool) ($map->config['legacy_pins'] ?? false),
            ],
            'settings_url' => route('entities.map-settings.update', [$this->campaign->id, $map->entity->id]),
            'tiling_prompt_url' => route('entities.map-tiling-prompt.update', [$this->campaign->id, $map->entity->id]),
            'show_url' => route('entities.show', [$this->campaign->id, $map->entity->id]),
            'edit_url' => route('entities.edit', [$this->campaign->id, $map->entity->id]),
        ];
    }

    protected function tilingPromptEligible(): bool
    {
        // Disabled: migrating a plain image map to tiling moves it onto a different coordinate
        // system, which shifts existing pins off their original positions. Keep this eligibility
        // check off until migration can preserve pin placement, so the prompt never renders.
        return false;
    }
}
