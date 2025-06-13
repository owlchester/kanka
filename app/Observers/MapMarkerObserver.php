<?php

namespace App\Observers;

use App\Models\MapMarker;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Str;

class MapMarkerObserver
{
    use PurifiableTrait;

    public function saving(MapMarker $mapMarker)
    {
        $mapMarker->opacity = round($mapMarker->opacity, 1);
        $mapMarker->custom_icon = $this->sanitizeCustomIcon($mapMarker);

        if ($mapMarker->size_id != 6) {
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
