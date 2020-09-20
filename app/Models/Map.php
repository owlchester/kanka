<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Ability
 * @package App\Models
 * @property int $map_id
 * @property int $location_id
 * @property int $width
 * @property int $height
 * @property int $grid
 * @property string $distance_name
 * @property int $distance_measure
 * @property int $min_zoom
 * @property int $max_zoom
 * @property int $initial_zoom
 * @property int $center_x
 * @property int $center_y
 * @property Map $map
 * @property Map[] $maps
 * @property Location $location
 * @property MapLayer[] $layers
 * @property MapMarker[] $markers
 * @property MapGroup[] $groups
 * @property [] $grids
 */
class Map extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        NodeTrait,
        SimpleSortableTrait,
        SoftDeletes;

    const MAX_ZOOM = 10;
    const MIN_ZOOM = -10;

    /**
     * @var array
     */
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
        'distance_name',
        'distance_measure',
        'min_zoom',
        'max_zoom',
        'initial_zoom',
        'center_x',
        'center_y',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'entry'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'map_id',
        'location_id',
        'is_private',
        'tags',
        'has_image',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'map.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'map_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'map';

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
     * @param $value
     */
    public function setMapIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
            'map',
            'map.entity',
        ]);
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
            ->with('entity');
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
    public function menuItems($items = [])
    {
        $campaign = CampaignLocalization::getCampaign();

        $items['maps'] = [
            'name' => 'maps.show.tabs.maps',
            'route' => 'maps.maps',
            'count' => $this->descendants()->count()
        ];
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
        for($i = $grid; $i <= $this->height; $i += $grid) {
            $lines[] = [$i, 0, $i, $this->width];
        }

        // Vertical lines
        for($i = $grid; $i <= $this->width; $i += $grid) {
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
     * @param bool $groups
     * @return string
     */
    public function activeLayers(bool $groups = true): string
    {
        $layers = ['baseLayer' . $this->id];
        if ($groups) {
            foreach ($this->groups->where('is_shown', true) as $group) {
                $layers[] = 'group' . $group->id;
            }
            foreach ($this->layers->where('type_id', 2) as $layer) {
                $layers[] = 'layer' . $layer->id;
            }
        }

        return implode(', ', $layers);
    }

    /**
     * List of markers for the map legend (ordered by "name")
     * @return array
     */
    public function legendMarkers(): array
    {
        $markers = new Collection();
        $groups = [];

        /** @var MapMarker $marker */
        foreach ($this->markers()->with(['group', 'entity'])->get() as $marker) {
            if (!$marker->visible()) {
                continue;
            }
            if (!empty($marker->group)) {
                if (empty($groups[$marker->group_id])) {
                    $groups[$marker->group_id] = [
                        'name' => $marker->group->name,
                        'lower_name' => strtolower($marker->group->name),
                        'id' => $marker->group_id,
                        'markers' => new Collection()
                    ];
                }
                $groups[$marker->group_id]['markers']->add([
                    'id' => $marker->id,
                    'longitude' => $marker->longitude,
                    'latitude' => $marker->latitude,
                    'name' => $marker->markerTitle(),
                    'lower_name' => strtolower($marker->markerTitle()),
                ]);
                continue;
            }
            $markers->add([
                'id' => $marker->id,
                'longitude' => $marker->longitude,
                'latitude' => $marker->latitude,
                'name' => $marker->markerTitle(),
                'lower_name' => strtolower($marker->markerTitle()),
            ]);
        }

        $all = $markers->sortBy('lower_name')->toArray();

        usort($groups, function ($a, $b) {
            return $a['lower_name'] > $b['lower_name'];
        });

        foreach ($groups as $id => $group) {
            // Reorder group
            $group['markers'] = $group['markers']->sortBy('lower_name')->toArray();
            $all[] = $group;
        }

        usort($all, function ($a, $b) {
            return $a['lower_name'] > $b['lower_name'];
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
            return -2;
        }

        // if the initial zoom is further away than the min zoom, adapt
        if ($this->min_zoom > $this->initial_zoom && $this->initial_zoom > self::MIN_ZOOM) {
            return $this->initial_zoom;
        }
        return (int) max($this->min_zoom, self::MIN_ZOOM);
    }

    /**
     * Maximum zoom of a map
     * @return int
     */
    public function maxZoom(): float
    {
        if (!is_numeric($this->max_zoom)) {
            return 2.75;
        }
        return (float) min($this->max_zoom, self::MAX_ZOOM);
    }

    /**
     * Initiall zoom of a map
     * @return int
     */
    public function initialZoom(): int
    {
        if (!is_numeric($this->initial_zoom)) {
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

    public function centerFocus(): string
    {
        $latitude = floor($this->height / 2);
        if (!empty($this->center_y)) {
            $latitude = $this->center_y;
        }
        $longitude = floor($this->width / 2);
        if (!empty($this->center_x)) {
            $longitude = $this->center_x;
        }

        return "$latitude, $longitude";
    }
}
