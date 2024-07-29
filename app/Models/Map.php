<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Ability
 * @package App\Models
 * @property int|null $map_id
 * @property int|null $location_id
 * @property int|null $width
 * @property int|null $height
 * @property int $grid
 * @property int $min_zoom
 * @property int $max_zoom
 * @property int $initial_zoom
 * @property float $center_x
 * @property float $center_y
 * @property int $center_marker_id
 * @property bool $is_real
 * @property bool $has_clustering
 * @property int $chunking_status
 * @property array $config
 * @property Map|null $map
 * @property Map[] $maps
 * @property Location|null $location
 * @property Collection|MapLayer[] $layers
 * @property Collection|MapMarker[] $markers
 * @property MapMarker $center_marker
 * @property Collection|MapGroup[] $groups
 * @property array $grids
 */
class Map extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasEntry;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

    public const MAX_ZOOM = 10;
    public const MIN_ZOOM = -10;
    public const MAX_ZOOM_REAL = 15;
    public const MIN_ZOOM_REAL = 2;
    public const MIN_ZOOM_CHUNK = 8;
    public const MAX_ZOOM_CHUNK = 13;

    public const CHUNKING_RUNNING = 1;
    public const CHUNKING_FINISHED = 2;
    public const CHUNKING_ERROR = 3;

    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'entry',
        'map_id',
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

    public $casts = [
        'config' => 'array',
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'map_id',
        'location_id',
        'center_marker_id'
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'layers',
        'groups',
        'markers'
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

    /**
     * Entity type
     */
    protected string $entityType = 'map';

    /**
     * Extra relations loaded for the API endpoint
     * @var string[]
     */
    public array $apiWith = ['groups', 'layers'];

    protected array $exploreGridFields = ['is_real'];

    /**
     * Parent ID used for the Node Trait
     * @return string
     */
    public function getParentKeyName()
    {
        return 'map_id';
    }


    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'maps' => function ($sub) {
                $sub->select('id', 'map_id', 'name');
            },
            'children' => function ($sub) {
                $sub->select('id', 'map_id');
            },
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
        ]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['map_id', 'location_id'];
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo('App\Models\Map', 'map_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function maps(): HasMany
    {
        return $this->hasMany('App\Models\Map', 'map_id', 'id');
    }

    public function layers(): HasMany
    {
        return $this->hasMany('App\Models\MapLayer', 'map_id', 'id')
            ->with('image');
    }

    public function groups(): HasMany
    {
        return $this->hasMany('App\Models\MapGroup', 'map_id', 'id');
    }

    public function markers(): HasMany
    {
        return $this->hasMany('App\Models\MapMarker', 'map_id', 'id')
            ->with(['entity', 'group', 'map', 'entity.image']);
    }

    public function center_marker(): HasOne
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

    /**
     */
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

        //If is the last position remove last+1 position from the options array
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

        //If is the last position remove last+1 position from the options array
        if ($position == array_key_last($options) - 1 && count($options) > 1) {
            array_pop($options);
        }
        return $options;
    }

    /**
     */
    public function activeLayers(bool $groups = true): string
    {
        $layers = [];
        if (!$this->isReal()) {
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
        $markers = new Collection();
        $groups = [];

        foreach ($this->markers as $marker) {
            if (!$marker->visible()) {
                continue;
            }
            if (!empty($marker->group)) {
                if (empty($groups[$marker->group_id])) {
                    $groups[$marker->group_id] = [
                        'name' => $marker->group->name,
                        'lower_name' => mb_strtolower($marker->group->name),
                        'id' => $marker->group_id,
                        'markers' => new Collection()
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
        if (!is_numeric($this->min_zoom)) {
            if ($this->isReal() || $this->isChunked()) {
                return self::MIN_ZOOM_REAL;
            }
            return -2;
        }

        // if the initial zoom is further away than the min zoom, adapt
        if ($this->min_zoom > $this->initial_zoom && $this->initial_zoom > self::MIN_ZOOM) {
            return $this->initial_zoom;
        }
        // The max zoom is based on the chunked image so we trust this.
        if ($this->isChunked()) {
            return $this->min_zoom;
        }
        $min = $this->isReal() ? self::MIN_ZOOM_REAL : self::MIN_ZOOM;
        return (int) max($this->min_zoom, $min);
    }

    /**
     * Maximum zoom of a map
     */
    public function maxZoom(): float
    {
        if (!is_numeric($this->max_zoom)) {
            if ($this->isChunked()) {
                return 13;
            }
            if ($this->isReal()) {
                return self::MAX_ZOOM_REAL;
            }
            return 2.75;
        }
        // The max zoom is based on the chunked image so we trust this.
        if ($this->isChunked()) {
            return $this->max_zoom;
        }
        $max = $this->isReal() ? self::MAX_ZOOM_REAL : self::MAX_ZOOM;
        return (float) min($this->max_zoom, $max);
    }

    /**
     * Initiall zoom of a map
     */
    public function initialZoom(): int
    {
        if (!is_numeric($this->initial_zoom)) {
            if ($this->isReal() || $this->isChunked()) {
                return 12;
            }
            return 0;
        }

        if ($this->initial_zoom > self::MAX_ZOOM) {
            return self::MAX_ZOOM;
        }
        if ($this->initial_zoom < self::MIN_ZOOM) {
            return self::MIN_ZOOM;
        }
        return (int) $this->initial_zoom;
    }

    /**
     */
    public function centerFocus(): string
    {
        // Init position in the middle of the map
        $latitude = $longitude = 0;
        if ($this->isReal()) {
            $latitude = 46.205;
            $longitude = 6.147;
        } elseif ($this->isChunked()) {
            $latitude = 0;
            $longitude = 0;
        } else {
            $latitude = floor($this->height / 2);
            $longitude = floor($this->width / 2);
        }

        // If we have a center marker
        if ($this->center_marker != null) {
            //use his position
            $latitude = $this->center_marker->latitude;
            $longitude = $this->center_marker->longitude;
        } else {
            // Use the center positions if they exist
            if (!empty($this->center_y)) {
                $latitude = $this->center_y;
            }

            if (!empty($this->center_x)) {
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

        $min = $extend ? -50 : 0;
        return "[[{$min}, {$min}], [{$height}, {$width}]]";
    }

    /**
     * Whenever a map gets updated, its height and width are reset to re-calculate them on rendering
     * This is because the map's image is on the entity, or from the gallery
     */
    protected function prepareBounds(): void
    {
        if (!empty($this->height)) {
            return;
        }

        // Prioritize the gallery image, and fall back on the uploaded image
        if (!empty($this->entity->image)) {
            $path = $this->entity->image->path;
        } elseif ($this->entity->image_path) {
            $path = $this->entity->image_path;
        }
        if (empty($path)) {
            return;
        }

        $contents = Storage::get($path);
        if (Str::endsWith($path, '.svg')) {
            $xml = simplexml_load_string($contents);
            $width = $xml->attributes()->width;
            $height = $xml->attributes()->height;
        } else {
            $image = imagecreatefromstring($contents);
            $width = imagesx($image);
            $height = imagesy($image);
        }

        $this->height = $height;
        $this->width = $width;
        $this->saveQuietly();
    }

    /**
     * Copy related elements to the target
     */
    public function copyRelatedToTarget(Map $target): void
    {
        $groups = [];
        foreach ($this->layers as $sub) {
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $target->id;

            if (!empty($sub->image_path) && Storage::exists($sub->image_path)) {
                $uniqid = uniqid();
                $newPath = str_replace('.', $uniqid . '.', $sub->image_path);
                $newSub->image_path = $newPath;
                if (!Storage::exists($newPath)) {
                    Storage::copy($sub->image_path, $newPath);
                }
            }
            $newSub->saveQuietly();
        }
        foreach ($this->groups as $sub) {
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $target->id;
            $newSub->saveQuietly();
            $groups[$sub->id] = $newSub->id;
        }
        foreach ($this->markers as $sub) {
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $target->id;
            $newSub->group_id = !empty($newSub->group_id) && isset($groups[$newSub->group_id]) ? $groups[$newSub->group_id] : null;

            // If moving to another campaign, switch the markers pointing to an entity
            if (!empty($newSub->entity_id) && $target->campaign_id != $this->campaign_id) {
                $newSub->entity_id = null;
                if ($newSub->icon == 4) {
                    $newSub->icon = 1;
                }
                if (empty($newSub->name)) {
                    // Because the permission engine is already set on the new campaign, searching the marker's entity
                    // will always fail. So we need to go get it directly
                    $raw = DB::table('entities')
                        ->select('name')
                        ->where('id', $sub->entity_id)
                        ->first();
                    $newSub->name = $raw ? $raw->name : 'Copy of #' . $sub->id;
                }
            }
            $newSub->saveQuietly();
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
        if (!$this->entity->hasImage()) {
            return false;
        }
        return !($this->isChunked() && ($this->chunkingError() || $this->chunkingRunning()));
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
     * Check if a map has a chunked tileset
     */
    public function isChunked(): bool
    {
        return !empty($this->chunking_status);
    }

    /**
     * Check if a map is currently being chunked
     */
    public function chunkingReady(): bool
    {
        return !$this->chunkingError() && !$this->chunkingRunning();
    }

    /**
     * Check if a map encountered a chunking error
     */
    public function chunkingError(): bool
    {
        return $this->chunking_status == self::CHUNKING_ERROR;
    }
    /**
     * Check if a map encountered a chunking error
     */
    public function chunkingRunning(): bool
    {
        return $this->chunking_status == self::CHUNKING_RUNNING;
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
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'map_id',
            'location_id',
        ];
    }

    public function hasDistanceUnit(): bool
    {
        //return false;
        return !empty($this->config['distance_measure']);
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
                'icon' => 'fa-solid fa-layer-group',
                'label' => 'maps.panels.layers',
            ];
            $newActions[] = [
                'route' => route('maps.map_groups.index', [$campaign, $this]),
                'icon' => 'fa-solid fa-map-signs',
                'label' => 'maps.panels.groups',
            ];
            $newActions[] = [
                'route' => route('maps.map_markers.index', [$campaign, $this]),
                'icon' => 'fa-solid fa-map-pin',
                'label' => 'maps.panels.markers',
            ];
        }
        array_splice($actions, 2, 0, $newActions);

        return $actions;
    }
}
