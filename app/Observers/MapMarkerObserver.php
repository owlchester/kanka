<?php

namespace App\Observers;

use App\Events\Maps\MarkerChanged;
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

        // Only the legacy marker form ever submits size_id explicitly (a preset 1-5, or "custom" 6).
        // v4 map explorer circles never send it, so on update size_id just keeps whatever value is
        // already persisted (the column's DB default) without ever changing — checking dirtiness,
        // not the raw value, is what tells "no size was chosen" apart from "size_id happens to
        // already equal the DB default", which `is_null()` cannot do once a row has round-tripped
        // through the database.
        if ($mapMarker->isDirty('size_id') && $mapMarker->size_id != 6) {
            $mapMarker->circle_radius = null;
        }
    }

    public function saved(MapMarker $mapMarker)
    {
        $mapMarker->map->touchSilently();
    }

    public function created(MapMarker $mapMarker): void
    {
        $this->broadcastChange($mapMarker, 'created');
    }

    public function updated(MapMarker $mapMarker): void
    {
        $this->broadcastChange($mapMarker, 'updated');
    }

    public function deleted(MapMarker $mapMarker)
    {
        $mapMarker->map->touchSilently();
        $this->broadcastChange($mapMarker, 'deleted');
    }

    protected function broadcastChange(MapMarker $mapMarker, string $action): void
    {
        MarkerChanged::dispatch($mapMarker, $action);
        MarkerChanged::dispatch($mapMarker, $action, true);
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
