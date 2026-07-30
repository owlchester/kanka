<?php

return [
    /**
     * Images at or above this size (in KB) get tiled into a Leaflet-servable
     * pyramid when assigned as a map's base image or a map layer's image.
     */
    'tiling_threshold_kb' => env('MAP_TILING_THRESHOLD_KB', 10 * 1024),
];
