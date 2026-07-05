<?php

namespace App\Observers;

use App\Enums\MapMarkerShape;
use App\Models\MapMarker;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Str;

class MapMarkerObserver
{
    use PurifiableTrait;

    public function saving(MapMarker $mapMarker): void
    {
        $mapMarker->opacity = round($mapMarker->opacity, 1);
        $mapMarker->custom_icon = $this->sanitizeCustomIcon($mapMarker);

        // v4 map explorer circles are created with shape_id = circle but no size_id at all; legacy
        // circle markers (preset sizes 1-5, or the "custom" size 6) always set a size_id, so we only
        // need to skip the clear when size_id is genuinely absent, not merely whenever it's a circle.
        $isNewCircleWithoutSizeId = $mapMarker->shape_id === MapMarkerShape::circle && is_null($mapMarker->size_id);

        if ($mapMarker->size_id != 6 && ! $isNewCircleWithoutSizeId) {
            $mapMarker->circle_radius = null;
        }
    }

    public function saved(MapMarker $mapMarker)
    {
        $mapMarker->map->touchSilently();
    }

    public function deleted(MapMarker $mapMarker)
    {
        $mapMarker->map->touchSilently();
    }

    /**
     * Sanitize the custom icon (i or svg html element)
     *
     * @return string|null
     */
    protected function sanitizeCustomIcon(MapMarker $mapMarker)
    {
        if (empty($mapMarker->custom_icon)) {
            return null;
        }

        if (Str::startsWith($mapMarker->custom_icon, ['<svg', '<?xml'])) {
            $sanitizer = new Sanitizer;
            $cleanSvg = $sanitizer->sanitize($mapMarker->custom_icon);
            if ($cleanSvg !== false) {
                return $cleanSvg;
            } else {
                return null;
            }
        } elseif (Str::startsWith($mapMarker->custom_icon, ['<i ', 'fa-', 'ra '])) {
            return $this->purify($mapMarker->custom_icon);
        }

        return null;
    }
}
