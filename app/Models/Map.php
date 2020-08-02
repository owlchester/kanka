<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        $groups = $this->groups()->orderBy('name')->get();
        foreach ($groups as $group) {
            $options[$group->id] = $group->name;
        }
        return $options;
    }

    /**
     * @return string
     */
    public function activeLayers(): string
    {
        $layers = ['baseLayer' . $this->id];
        foreach ($this->groups as $group) {
            $layers[] = 'group' . $group->id;
        }

        return implode(', ', $layers);
    }
}
