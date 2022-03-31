<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
 * @property float $center_x
 * @property float $center_y
 * @property int $center_marker_id
 * @property bool $is_real
 * @property Map $map
 * @property Map[] $maps
 * @property Location $location
 * @property MapLayer[] $layers
 * @property MapMarker[] $markers
 * @property MapMarker $center_marker
 * @property MapGroup[] $groups
 * @property [] $grids
 */
class Map extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        Nested,
        SimpleSortableTrait,
        SoftDeletes;

    const MAX_ZOOM = 10;
    const MIN_ZOOM = -10;
    const MAX_ZOOM_REAL = 15;
    const MIN_ZOOM_REAL = 2;

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
        'center_marker_id',
        'is_real',
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
        'map_id',
        'location_id',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
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
     * @param bool $groups
     * @return string
     */
    public function activeLayers(bool $groups = true): string
    {
        $layers = [];
        if (!$this->is_real) {
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
                    'name' => str_replace("\\'", "'", $marker->markerTitle($link)),
                    'lower_name' => strtolower($marker->markerTitle(false)),
                ]);
                continue;
            }
            $markers->add([
                'id' => $marker->id,
                'longitude' => $marker->longitude,
                'latitude' => $marker->latitude,
                'name' => $marker->markerTitle($link),
                'lower_name' => strtolower($marker->markerTitle(false)),
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
            if ($this->is_real) {
                return self::MIN_ZOOM_REAL;
            }
            return -2;
        }

        // if the initial zoom is further away than the min zoom, adapt
        if ($this->min_zoom > $this->initial_zoom && $this->initial_zoom > self::MIN_ZOOM) {
            return $this->initial_zoom;
        }
        $min = $this->is_real ? self::MIN_ZOOM_REAL : self::MIN_ZOOM;
        return (int) max($this->min_zoom, $min);
    }

    /**
     * Maximum zoom of a map
     * @return int
     */
    public function maxZoom(): float
    {
        if (!is_numeric($this->max_zoom)) {
            if ($this->is_real) {
                return self::MAX_ZOOM_REAL;
            }
            return 2.75;
        }
        $max = $this->is_real ? self::MAX_ZOOM_REAL : self::MAX_ZOOM;
        return (float) min($this->max_zoom, $max);
    }

    /**
     * Initiall zoom of a map
     * @return int
     */
    public function initialZoom(): int
    {
        if (!is_numeric($this->initial_zoom)) {
            if ($this->is_real) {
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
        if ($this->is_real) {
            $latitude = 46.205;
            $longitude = 6.147;
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
        return "$latitude, $longitude";
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
        return "[[$min, $min], [$height, $width]]";
    }

    /**
     * Copy related elements to the target
     * @param MiscModel $target
     */
    public function copyRelatedToTarget(MiscModel $target)
    {
        $groups = [];
        foreach ($this->layers as $sub) {
            $newSub = $sub->replicate();
            $newSub->savingObserver = false;
            $newSub->map_id = $target->id;

            if (!empty($sub->image) && Storage::exists($sub->image)) {
                $uniqid = uniqid();
                $newPath = str_replace('.', $uniqid . '.', $sub->image);
                $newSub->image = $newPath;
                if (!Storage::exists($newPath)) {
                    Storage::copy($sub->image, $newPath);
                }
            }
            $newSub->save();
        }
        foreach ($this->groups as $sub) {
            $newSub = $sub->replicate();
            $newSub->savingObserver = false;
            $newSub->map_id = $target->id;
            $newSub->save();
            $groups[$sub->id] = $newSub->id;
        }
        foreach ($this->markers as $sub) {
            $newSub = $sub->replicate();
            $newSub->savingObserver = false;
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
            $newSub->save();
        }
    }
}
