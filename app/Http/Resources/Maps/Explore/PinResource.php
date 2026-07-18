<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\Entity;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapMarker $resource
 */
class PinResource extends JsonResource
{
    use CampaignAware;

    protected Entity $mapEntity;

    public function mapEntity(Entity $mapEntity): self
    {
        $this->mapEntity = $mapEntity;

        return $this;
    }

    public function toArray(Request $request): array
    {
        $marker = $this->resource;

        return [
            'id' => $marker->id,
            'name' => $marker->name ?: ($marker->entity->name ?? ''),
            'entry' => $marker->parsedEntry(),
            // The raw stored entry (mentions as [type:id] bracket placeholders, not resolved
            // anchors) — this is the format Tiptap's client-side mention parsing expects, same
            // as every other Tiptap-editable field in the app (see tiptap_editor.blade.php).
            // getEntryForEditionAttribute()/Mentions::parseForEdit() renders mentions as <a
            // href="#" class="mention"> anchors for a different, non-Tiptap legacy edit
            // surface; feeding that to Tiptap makes its Link extension claim the anchor
            // instead of the Mention node, since Mention's parseHTML only matches
            // span[data-mention].
            'entry_for_edition' => (string) $marker->{$marker->entryFieldName()},
            'group_id' => $marker->group_id,
            'latitude' => (float) $marker->latitude,
            'longitude' => (float) $marker->longitude,
            'shape' => $marker->shape_id?->name ?? 'marker',
            'colour' => $marker->colour,
            'font_colour' => $marker->font_colour,
            'icon' => $marker->exploreIcon(),
            'size_id' => $marker->size_id,
            'pin_size' => $marker->pin_size,
            'circle_radius' => $marker->circle_radius,
            'opacity' => (float) ($marker->opacity ?: 100),
            'custom_shape' => $this->polygonPoints($marker->custom_shape),
            'polygon_style' => $marker->polygon_style ?? [],
            'shape_id' => $marker->shape_id?->value,
            'icon_id' => $marker->icon,
            'custom_icon' => $marker->custom_icon,
            'entity_id' => $marker->entity_id,
            'entity_name' => $marker->entity?->name,
            'visibility_id' => $marker->visibility_id?->value,
            'preview_url' => route('entities.map-markers.preview', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'destroy_url' => route('entities.map-markers.destroy', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'update_url' => route('entities.map-markers.update', [$this->campaign->id, $this->mapEntity->id, $marker->id]),
            'is_draggable' => (bool) $marker->is_draggable,
            'css' => $marker->css,
            'move_url' => route('maps.markers.move', [$this->campaign->id, $marker->map_id, $marker->id]),
        ];
    }

    /**
     * Parse the raw "lat,lng lat,lng ..." custom_shape string (see MapMarker::marker()) into
     * an array of [lat, lng] float pairs for the Vue map explorer.
     *
     * @return array<int, array{0: float, 1: float}>
     */
    private function polygonPoints(?string $customShape): array
    {
        if (empty($customShape)) {
            return [];
        }

        $points = [];
        $segments = explode(' ', str_replace("\r\n", ' ', trim($customShape)));
        foreach ($segments as $segment) {
            $coords = explode(',', $segment);
            if (isset($coords[0], $coords[1]) && $coords[0] !== '' && $coords[1] !== '') {
                $points[] = [(float) $coords[0], (float) $coords[1]];
            }
        }

        return $points;
    }
}
