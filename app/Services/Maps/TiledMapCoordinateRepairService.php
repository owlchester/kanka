<?php

namespace App\Services\Maps;

use App\Enums\MapMarkerShape;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TiledMapCoordinateRepairService
{
    public function repair(int $mapId, bool $execute): array
    {
        return DB::transaction(function () use ($mapId, $execute) {
            $map = Map::query()->when($execute, fn ($query) => $query->lockForUpdate())->findOrFail($mapId);
            $map->load([
                'entity' => fn ($query) => $query->when($execute, fn ($query) => $query->lockForUpdate()),
                'entity.image' => fn ($query) => $query->when($execute, fn ($query) => $query->lockForUpdate()),
            ]);
            $image = $map->entity?->image;
            if ($map->isReal() || ! $image?->isTiled()) {
                throw new RuntimeException('Map no longer has a finished tiled image.');
            }

            $width = (int) ($map->width ?: $image->width());
            $height = (int) ($map->height ?: $image->height());
            $zoom = $image->metadata['tile_max_zoom'] ?? null;
            if ($width <= 0 || $height <= 0 || ! is_numeric($zoom) || (int) $zoom != $zoom || $zoom < 0 || $zoom > 30) {
                throw new RuntimeException('Missing or invalid image dimensions or recorded tile_max_zoom.');
            }
            $scale = 2 ** (int) $zoom;
            $changes = [];
            $markers = $map->markers()->withoutGlobalScopes()->where('latitude', '<', 0)
                ->when($execute, fn ($query) => $query->lockForUpdate())->get();
            foreach ($markers as $marker) {
                $changes[$marker->id] = $this->markerChanges($marker, $width, $height, $scale);
            }

            $center = [];
            if ($map->center_y !== null && $map->center_y < 0) {
                if ($map->center_x === null) {
                    throw new RuntimeException('Negative saved center has no longitude.');
                }
                [$latitude, $longitude] = $this->point($map->center_y, $map->center_x, $width, $height, $scale);
                $center = ['center_y' => $latitude, 'center_x' => $longitude];
            }

            if ($execute) {
                foreach ($changes as $id => $attributes) {
                    MapMarker::query()->whereKey($id)->toBase()->update($attributes);
                }
                if ($center !== []) {
                    Map::query()->whereKey($mapId)->toBase()->update($center);
                }
            }

            return ['markers' => $changes, 'center' => $center, 'scale' => $scale];
        });
    }

    protected function markerChanges(MapMarker $marker, int $width, int $height, int $scale): array
    {
        [$latitude, $longitude] = $this->point($marker->latitude, $marker->longitude, $width, $height, $scale);
        $changes = ['latitude' => $latitude, 'longitude' => $longitude];
        if (in_array($marker->shape_id, [MapMarkerShape::poly, MapMarkerShape::path], true)) {
            $shape = trim((string) $marker->custom_shape);
            if ($shape === '') {
                throw new RuntimeException("Marker {$marker->id}: empty polygon/path geometry.");
            }
            $vertices = [];
            foreach (preg_split('/\s+/', $shape) as $vertex) {
                $pair = explode(',', $vertex);
                if (count($pair) !== 2 || ! is_numeric($pair[0]) || $pair[0] > 0) {
                    throw new RuntimeException("Marker {$marker->id}: malformed or mixed polygon/path coordinates.");
                }
                [$lat, $lng] = $this->point($pair[0], $pair[1], $width, $height, $scale);
                $vertices[] = sprintf('%.10F,%.10F', $lat, $lng);
            }
            $changes['custom_shape'] = implode(' ', $vertices);
        }
        if ($marker->shape_id === MapMarkerShape::circle) {
            $radius = ($marker->circle_radius ?: 50) * $scale;
            if (! is_finite((float) $radius) || $radius <= 0 || $radius > 65535) {
                throw new RuntimeException("Marker {$marker->id}: converted radius exceeds the unsigned SMALLINT column.");
            }
            $changes['circle_radius'] = $radius;
        }

        return $changes;
    }

    protected function point(mixed $latitude, mixed $longitude, int $width, int $height, int $scale): array
    {
        if (! is_numeric($latitude) || ! is_numeric($longitude)) {
            throw new RuntimeException('Non-numeric coordinate.');
        }
        $latitude = $height + (float) $latitude * $scale;
        $longitude = (float) $longitude * $scale;
        if (! is_finite($latitude) || ! is_finite($longitude) || $latitude < 0 || $latitude > $height || $longitude < 0 || $longitude > $width) {
            throw new RuntimeException("Converted coordinate [{$latitude}, {$longitude}] is outside {$width}x{$height} image bounds.");
        }

        return [$latitude, $longitude];
    }
}
