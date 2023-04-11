<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class Ability
 * @package App\Models
 * @property int|null $map_id
 * @property int|null $location_id
 * @property int $width
 * @property int $height
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
    use CampaignTrait;
    use ExportableTrait;
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

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'entry',
        'image',
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

    protected $sortable = [
        'name',
        'type',
        'map.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'map_id',
        'center_marker_id'
    ];


    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'layers',
        'groups',
        'markers'
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'map';

    /**
     * Extra relations loaded for the API endpoint
     * @var string[]
     */
    public $apiWith = ['groups', 'layers'];

    /**
     * Parent ID used for the Node Trait
     * @return string
     */
    public function getParentIdName()
    {
        return 'map_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setMapIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity',
            'map',
            'map.entity',
            'maps' => function ($sub) {
                $sub->select('id', 'name');
            },
            'children' => function ($sub) {
                $sub->select('id', 'map_id');
            },
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['map_id'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function map()
    {
        return $this->belongsTo('App\Models\Map', 'map_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maps()
    {
        return $this->hasMany('App\Models\Map', 'map_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function layers()
    {
        return $this->hasMany('App\Models\MapLayer', 'map_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany('App\Models\MapGroup', 'map_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function markers()
    {
        return $this->hasMany('App\Models\MapMarker', 'map_id', 'id')
            ->with(['entity', 'group']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function center_marker()
    {
        return $this->hasOne('App\Models\MapMarker', 'id', 'center_marker_id');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->maps as $child) {
            $child->map_id = null;
            $child->save();
        }

        return parent::detach();
    }

    /**
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $items['second']['maps'] = [
            'name' => 'maps.show.tabs.maps',
            'route' => 'maps.maps',
            'count' => $this->maps()->count()
        ];
        if (auth()->check() && auth()->user()->can('update', $this)) {
            $items['second']['layers'] = [
                'name' => 'maps.panels.layers',
                'route' => 'maps.map_layers.index',
                'count' => $this->layers->count()
            ];
            $items['second']['groups'] = [
                'name' => 'maps.panels.groups',
                'route' => 'maps.map_groups.index',
                'count' => $this->groups->count()
            ];
            $items['second']['markers'] = [
                'name' => 'maps.panels.markers',
                'route' => 'maps.map_markers.index',
                'count' => $this->markers->count()
            ];
        }
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.map');
    }

    /**
     * @return array
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
    public function groupPositionOptions($position = null): array
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
    public function layerPositionOptions($position = null): array
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
     * @param bool $groups
     * @return string
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
     * @return array
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
                'visibility' => $marker->visibility_id !== 1 ? $marker->visibilityIcon() : null,
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
     * @return int
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
     * @return float
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
     * @return int
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
     * @return string
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
     * @return string
     */
    public function bounds(bool $extend = false): string
    {
        $extra = $extend ? 50 : 0;
        $height = floor((empty($this->height) ? 1000 : $this->height) / 1) + $extra;
        $width = floor((empty($this->width) ? 1000 : $this->width) / 1) + $extra;

        $min = $extend ? -50 : 0;
        return "[[{$min}, {$min}], [{$height}, {$width}]]";
    }

    /**
     * Copy related elements to the target
     * @param MiscModel $target
     */
    public function copyRelatedToTarget(MiscModel $target)
    {
        $groups = [];
        foreach ($this->layers as $sub) {
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $target->id;

            if (!empty($sub->image) && Storage::exists($sub->image)) {
                $uniqid = uniqid();
                $newPath = str_replace('.', $uniqid . '.', $sub->image);
                $newSub->image = $newPath;
                if (!Storage::exists($newPath)) {
                    Storage::copy($sub->image, $newPath);
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
     * @return bool
     */
    public function explorable(): bool
    {
        if (empty($this->image) && !$this->isReal()) {
            return false;
        }
        return ! ($this->isChunked() && ($this->chunkingError() || $this->chunkingRunning()));
    }

    /**
     * The explore link for a map, or the chunking process icon
     * @return string
     */
    public function exploreLink(): string
    {
        if (!$this->explorable()) {
            return '';
        }
        if ($this->isChunked()) {
            if ($this->chunkingError()) {
                return '<i class="fa-solid fa-exclamation-triangle" data-toggle="tooltip" title="' .
                    __('maps.errors.chunking.error', ['discord' => 'Discord']) . '"></i>';
            } elseif ($this->chunkingRunning()) {
                return '<i class="fa-solid fa-spin fa-spinner" data-toggle="tooltip" title="' .
                    __('maps.tooltips.chunking.running') . '"></i>';
            }
        }
        return '<a href="' . route('maps.explore', $this->id) . '" target="_blank" ' .
            'data-toggle="tooltip" title="' . __('maps.actions.explore') . '">' .
            '<i class="fa-solid fa-map" data-tree="escape"></i>' .
            '</a>';
    }

    /**
     * Prepare groups for clustering
     * @return string
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
     * @return bool
     */
    public function isReal(): bool
    {
        return (bool) $this->is_real;
    }

    /**
     * Check if a map has a chunked tileset
     * @return bool
     */
    public function isChunked(): bool
    {
        return !empty($this->chunking_status);
    }

    /**
     * Check if a map is currently being chunked
     * @return bool
     */
    public function chunkingReady(): bool
    {
        return !$this->chunkingError() && !$this->chunkingRunning();
    }

    /**
     * Check if a map encountered a chunking error
     * @return bool
     */
    public function chunkingError(): bool
    {
        return $this->chunking_status == self::CHUNKING_ERROR;
    }
    /**
     * Check if a map encountered a chunking error
     * @return bool
     */
    public function chunkingRunning(): bool
    {
        return $this->chunking_status == self::CHUNKING_RUNNING;
    }

    /**
     * Determine if the map uses marker clustering or not
     * @return bool
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
     * @param Campaign $campaign
     * @return string[]
     * @throws Exception
     */
    public function datagridActions(Campaign $campaign): array
    {
        $newActions = [];
        $actions = parent::datagridActions($campaign);

        if (auth()->check() && auth()->user()->can('update', $this)) {
            $newActions[] = '<li class="divider"></li>';
            $newActions[] = '<li>
                <a href="' . route('maps.map_layers.index', $this->id) . '" class="dropdown-item datagrid-dropdown-item" data-name="layers">
                    <i class="fa-solid fa-layer-group" aria-hidden="true"></i> ' . __('maps.panels.layers') . '
                </a>
            </li>';
            $newActions[] = '<li>
                <a href="' . route('maps.map_groups.index', $this->id) . '" class="dropdown-item datagrid-dropdown-item" data-name="groups">
                    <i class="fa-solid fa-map-signs" aria-hidden="true"></i> ' . __('maps.panels.groups') . '
                </a>
            </li>';
            $newActions[] = '<li>
                <a href="' . route('maps.map_markers.index', $this->id) . '" class="dropdown-item datagrid-dropdown-item" data-name="markers">
                    <i class="fa-solid fa-map-pin" aria-hidden="true"></i> ' . __('maps.panels.markers') . '
                </a>
            </li>';
        }
        array_splice($actions, 2, 0, $newActions);

        return $actions;
    }
}
