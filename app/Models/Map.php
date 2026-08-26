<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Class Map
 *
 * @property ?int $width
 * @property ?int $height
 * @property int $grid
 * @property int $min_zoom
 * @property int $max_zoom
 * @property int $initial_zoom
 * @property float $center_x
 * @property float $center_y
 * @property int $center_marker_id
 * @property bool $is_real
 * @property bool $has_clustering
 * @property array $config
 * @property ?Carbon $tiling_prompt_dismissed_at
 * @property Collection|MapLayer[] $layers
 * @property Collection|MapMarker[] $markers
 * @property MapMarker $centerMarker
 * @property Collection|MapGroup[] $groups
 * @property array $grids
 */
class Map extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'name',
        'location_id',
        'grid',
        'is_private',
        'height',
        'width',
        'min_zoom',
        'max_zoom',
        'initial_zoom',
        'center_x',
        'center_y',
        'center_marker_id',
        'is_real',
        'has_clustering',
        'config',
    ];

    protected $attributes = [
        'is_real' => false,
    ];

    public $casts = [
        'config' => 'array',
        'is_real' => 'boolean',
    ];

    protected array $sortable = [
        'name',
        'type',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
        'center_marker_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'layers',
        'groups',
        'markers',
    ];

    protected array $exportFields = [
        'base',
        'location_id',
        'grid',
        'height',
        'width',
        'min_zoom',
        'max_zoom',
        'initial_zoom',
        'center_x',
        'center_y',
        'center_marker_id',
        'is_real',
        'has_clustering',
        'config',
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * Extra relations loaded for the API endpoint
     *
     * @var string[]
     */
    public array $apiWith = ['groups', 'layers'];

    /**
     * @return HasMany<MapLayer, $this>
     */
    public function layers(): HasMany
    {
        return $this->hasMany('App\Models\MapLayer', 'map_id', 'id')
            ->with('image');
    }

    /**
     * @return HasMany<MapGroup, $this>
     */
    public function groups(): HasMany
    {
        return $this->hasMany('App\Models\MapGroup', 'map_id', 'id');
    }

    /**
     * @return HasMany<MapMarker, $this>
     */
    public function markers(): HasMany
    {
        return $this->hasMany('App\Models\MapMarker', 'map_id', 'id')
            ->with(['entity', 'entity.entityType', 'group', 'map', 'entity.image']);
    }

    /**
     * @return HasOne<MapMarker, $this>
     */
    public function centerMarker(): HasOne
    {
        return $this->hasOne('App\Models\MapMarker', 'id', 'center_marker_id');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.map');
    }

    public function grids(): array
    {
        $lines = [];

        // Horizontal lines
        $grid = $this->grid;
        for ($i = $grid; $i <= $this->height; $i += $grid) {
            $lines[] = [$i, 0, $i, $this->width];
        }

        // Vertical lines
        for ($i = $grid; $i <= $this->width; $i += $grid) {
            $lines[] = [0, $i, $this->height, $i];
        }

        return $lines;
    }

    /**
     * @return array|string[]
     */
    public function groupOptions(): array
    {
        $options = [null => ''];
        $groups = $this->groups->sortBy('name');
        foreach ($groups as $group) {
            $options[$group->id] = $group->name;
        }

        return $options;
    }

    /**
     * @return array|string[]
     */
    public function groupPositionOptions(?int $position = null): array
    {
        $options = [1 => __('maps/groups.placeholders.position')];
        $groups = $this->groups->sortBy('position');
        foreach ($groups as $group) {
            $options[$group->position + 1] = __('maps/groups.placeholders.position_list', ['name' => $group->name]);
        }

        // If is the last position remove last+1 position from the options array
        if ($position == array_key_last($options) - 1 && count($options) > 1) {
            array_pop($options);
        }

        return $options;
    }

    /**
     * @return array|string[]
     */
    public function layerPositionOptions(?int $position = null): array
    {
        $options = [1 => __('maps/layers.placeholders.position')];
        $layers = $this->layers->sortBy('position');
        foreach ($layers as $layer) {
            $options[$layer->position + 1] = __('maps/layers.placeholders.position_list', ['name' => $layer->name]);
        }

        // If is the last position remove last+1 position from the options array
        if ($position == array_key_last($options) - 1 && count($options) > 1) {
            array_pop($options);
        }

        return $options;
    }

    public function activeLayers(bool $groups = true): string
    {
        $layers = [];
        if (! $this->isReal()) {
            $layers = ['baseLayer' . $this->id];
        }
        if ($groups) {
            foreach ($this->groups->where('is_shown', true) as $group) {
                $layers[] = 'group' . $group->id;
            }
            foreach ($this->layers->where('type_id', 2)->whereNotNull('image') as $layer) {
                $layers[] = 'layer' . $layer->id;
            }
        }

        return implode(', ', $layers);
    }

    /**
     * List of markers for the map legend (ordered by "name")
     */
    public function legendMarkers(bool $link = true): array
    {
        $markers = new Collection;
        $groups = [];

        foreach ($this->markers as $marker) {
            if (! $marker->visible()) {
                continue;
            }
            if (! empty($marker->group)) {
                if (empty($groups[$marker->group_id])) {
                    $groups[$marker->group_id] = [
                        'name' => $marker->group->name,
                        'lower_name' => mb_strtolower($marker->group->name),
                        'id' => $marker->group_id,
                        'markers' => new Collection,
                    ];
                }
                $groups[$marker->group_id]['markers']->add([
                    'id' => $marker->id,
                    'longitude' => $marker->longitude,
                    'latitude' => $marker->latitude,
                    'name' => str_replace("\\'", "'", $marker->markerTitle($link)),
                    'lower_name' => mb_strtolower($marker->markerTitle(false)),
                ]);

                continue;
            }
            $markers->add([
                'id' => $marker->id,
                'longitude' => $marker->longitude,
                'latitude' => $marker->latitude,
                'name' => $marker->markerTitle($link),
                'lower_name' => mb_strtolower($marker->markerTitle(false)),
                'visibility' => $marker->skipAllIcon()->visibilityIcon(),
            ]);
        }

        $all = $markers->sortBy('lower_name')->toArray();

        usort($groups, function ($a, $b) {
            return strcmp($a['lower_name'], $b['lower_name']);
        });

        foreach ($groups as $id => $group) {
            // Reorder group
            $group['markers'] = $group['markers']->sortBy('lower_name')->toArray();
            $all[] = $group;
        }

        usort($all, function ($a, $b) {
            return strcmp($a['lower_name'], $b['lower_name']);
        });

        return $all;
    }

    /**
     * Minimum zoom of a map
     */
    public function minZoom(): int
    {
        $limits = $this->zoomLimits();

        if (! is_numeric($this->min_zoom)) {
            if ($this->isReal() || $this->isTiled()) {
                return config('limits.maps.zoom.real.min');
            }

            return -2;
        }

        // if the initial zoom is further away than the min zoom, adapt
        if ($this->min_zoom > $this->initial_zoom && $this->initial_zoom > $limits['min']) {
            return $this->initial_zoom;
        }
        // The max zoom is based on the tiled image so we trust this.
        if ($this->isTiled()) {
            return $this->min_zoom;
        }

        return (int) max($this->min_zoom, $limits['min']);
    }

    /**
     * Maximum zoom of a map
     */
    public function maxZoom(): float
    {
        $limits = $this->zoomLimits();

        if (! is_numeric($this->max_zoom)) {
            if ($this->isTiled()) {
                return config('limits.maps.zoom.tile.max');
            }
            if ($this->isReal()) {
                return $limits['max'];
            }

            return 2.75;
        }
        // The max zoom is based on the tiled image so we trust this.
        if ($this->isTiled()) {
            return $this->max_zoom;
        }

        return (float) min($this->max_zoom, $limits['max']);
    }

    /**
     * Initiall zoom of a map
     */
    public function initialZoom(): int
    {
        $limits = $this->zoomLimits();

        if (! is_numeric($this->initial_zoom)) {
            if ($this->isReal() || $this->isTiled()) {
                return 12;
            }

            return 0;
        }

        if ($this->initial_zoom > $limits['max']) {
            return $limits['max'];
        }
        if ($this->initial_zoom < $limits['min']) {
            return $limits['min'];
        }

        return (int) $this->initial_zoom;
    }

    /**
     * Zoom limits for the map's coordinate system.
     *
     * @return array{min: int, max: int}
     */
    protected function zoomLimits(): array
    {
        if ($this->isReal()) {
            return config('limits.maps.zoom.real');
        }

        return config('limits.maps.zoom.default');
    }

    public function centerFocus(): string
    {
        // Init position in the middle of the map
        $latitude = $longitude = 0;
        if ($this->isReal()) {
            $latitude = 46.205;
            $longitude = 6.147;
        } elseif ($this->height && $this->width) {
            $latitude = floor($this->height / 2);
            $longitude = floor($this->width / 2);
        }

        // If we have a center marker
        if ($this->centerMarker != null) {
            // use his position
            $latitude = $this->centerMarker->latitude;
            $longitude = $this->centerMarker->longitude;
        } else {
            // Use the center positions if they exist
            if ($this->center_y !== null) {
                $latitude = $this->center_y;
            }

            if ($this->center_x !== null) {
                $longitude = $this->center_x;
            }
        }

        return "{$latitude}, {$longitude}";
    }

    /**
     * Build the image's bounds for leaflet.
     * If the height or width is 0, which can happen with an svg with no height/width property,
     * we just assume 1000/1000 and wait for a user to come in discord for help.
     */
    public function bounds(bool $extend = false): string
    {
        $this->prepareBounds();
        $extra = $extend ? 50 : 0;
        $height = empty($this->height) ? 1000 : $this->height;
        $width = empty($this->width) ? 1000 : $this->width;
        $height = floor(($height) / 1) + $extra;
        $width = floor(($width) / 1) + $extra;

        $min = $extend ? -100 : 0;

        return "[[{$min}, {$min}], [{$height}, {$width}]]";
    }

    /**
     * Whenever a map gets updated, its height and width are reset to re-calculate them on rendering.
     * A gallery image (entity->image) is the single source of truth for its own dimensions — they're
     * read live off the Image and never persisted onto this row. A legacy directly-uploaded image
     * (entity->image_path) keeps the old calculate-once-and-cache-on-the-map behavior.
     */
    public function prepareBounds(): void
    {
        if (! empty($this->height)) {
            return;
        }

        if (! empty($this->entity->image)) {
            if ($this->entity->image->isTiled() && $this->entity->image->tilingReady()) {
                return;
            }
            $this->entity->image->ensureDimensions();
            $this->height = $this->entity->image->height() ?: 1000;
            $this->width = $this->entity->image->width() ?: 1000;

            return;
        }

        $path = $this->entity->image_path;
        if (empty($path) || ! Storage::exists($path)) {
            return;
        }

        $dimensions = Image::dimensionsForPath($path);
        $this->height = $dimensions['height'];
        $this->width = $dimensions['width'];

        // Don't save on the replica db
        if (auth()->check()) {
            $this->saveQuietly();
        }
    }

    /**
     * Determine if a map can be explored
     */
    public function explorable(): bool
    {
        if ($this->isReal()) {
            return true;
        }
        if (! $this->entity->hasImage()) {
            return false;
        }

        return ! $this->tilingRunning();
    }

    /**
     * Prepare groups for clustering
     */
    public function checkinGroups(): string
    {
        if (empty($this->groups)) {
            return '[]';
        }
        $ids = [];
        foreach ($this->groups as $group) {
            $ids[] = 'group' . $group->id;
        }

        return '[' . implode(', ', $ids) . ']';
    }

    /**
     * Check if a map is using the "real" world (openstreetmaps)
     */
    public function isReal(): bool
    {
        return (bool) $this->is_real;
    }

    /**
     * Check if a map's base image has a finished tile pyramid ready to serve
     */
    public function isTiled(): bool
    {
        return $this->entity->image?->isTiled() ?? false;
    }

    /**
     * Check if a map's base image can render one way or another (tiled, errored-fallback,
     * or never tiled) — only an in-progress tiling job blocks rendering.
     */
    public function tilingReady(): bool
    {
        return $this->entity->image === null || $this->entity->image->tilingReady();
    }

    /**
     * Check if a map's base image permanently failed tiling
     */
    public function tilingError(): bool
    {
        return $this->entity->image?->tilingError() ?? false;
    }

    /**
     * Check if a map's base image is currently being tiled
     */
    public function tilingRunning(): bool
    {
        return $this->entity->image?->tilingRunning() ?? false;
    }

    /**
     * Leaflet tile URL template for this map's base image tile pyramid, or null if not tiled.
     */
    public function tilesUrl(): ?string
    {
        return $this->isTiled() ? $this->entity->image->tilesUrlTemplate() : null;
    }

    /**
     * Determine if the map uses marker clustering or not
     */
    public function isClustered(): bool
    {
        return $this->has_clustering;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'location_id',
        ];
    }

    public function hasDistanceUnit(): bool
    {
        // return false;
        return ! empty($this->config['distance_measure']);
    }

    /**
     * Available datagrid actions
     */
    public function datagridActions(Campaign $campaign): array
    {
        $newActions = [];
        $actions = parent::datagridActions($campaign);

        if (auth()->check() && auth()->user()->can('update', $this)) {
            $newActions[] = null;
            $newActions[] = [
                'route' => route('maps.map_layers.index', [$campaign, $this]),
                'icon' => 'fa-regular fa-layer-group',
                'label' => 'maps.panels.layers',
            ];
            $newActions[] = [
                'route' => route('maps.map_groups.index', [$campaign, $this]),
                'icon' => 'fa-regular fa-map-signs',
                'label' => 'maps.panels.groups',
            ];
            $newActions[] = [
                'route' => route('maps.map_markers.index', [$campaign, $this]),
                'icon' => 'fa-regular fa-map-pin',
                'label' => 'maps.panels.markers',
            ];
        }
        array_splice($actions, 2, 0, $newActions);

        return $actions;
    }

    public function buildGroupTree(): string
    {
        $groups = $this->groups()->with('children')->whereNull('parent_id')->get()->sortBy('position');

        return $this->buildGroup($groups);
    }

    protected function buildGroup($groups): string
    {
        $json = '';
        foreach ($groups as $group) {
            $children = $group->children;
            $element = "{label: '" . str_replace('&amp;', '&', e($group->name)) . "', layer: group" . $group->id;
            if ($children) {
                $element .= ',children: [' . $this->buildGroup($children) . ']';
            }
            $json .= $element . '},';
        }

        return $json;
    }
}
