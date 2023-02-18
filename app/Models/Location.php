<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Location
 * @package App\Models
 * @property string $name
 * @property string $type
 * @property string $entry
 * @property string $image
 * @property string|null $map
 * @property boolean $is_private
 * @property boolean $is_map_private
 * @property integer|null $parent_location_id
 * @property Location|null $parentLocation
 * @property Map[]|Collection $maps
 * @property Location[]|Collection $descendants
 * @property Location[]|Collection $locations
 * @property Character[]|Collection $characters
 * @property Organisation[]|Collection $organisations
 * @property Family[]|Collection $families
 * @property Item[]|Collection $items
 */
class Location extends MiscModel
{
    use Acl
    ;
    use CampaignTrait;
    use ExportableTrait;
    use Nested;
    use SoftDeletes;
    use SortableTrait;


    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'image',
        'entry',
        'parent_location_id',
        'campaign_id',
        'is_private',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'parentLocation.name',
    ];

    protected $sortable = [
        'name',
        'type',
        'location.name',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'location';

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'parent_location_id',
    ];

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'parent_location_id';
    }

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext');
            },
            'parentLocation' => function ($sub) {
                $sub->select('id', 'name', 'campaign_id');
            },
            'parentLocation.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'locations' => function ($sub) {
                $sub->select('id', 'parent_location_id', 'campaign_id');
            },
            'characters' => function ($sub) {
                $sub->select('id', 'location_id', 'campaign_id');
            },
            'races'
        ]);
    }

    public function scopeDescendantDatagrid(Builder $query): Builder
    {
        return $query
            ->select(['id', 'image', 'name', 'type', 'parent_location_id', 'is_private'])
            ->with(['location', 'location.entity', 'entity', 'entity.tags', 'entity.image']);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['parent_location_id'];
    }

    /**
     *
     */
    public function parentLocation()
    {
        return $this->belongsTo('App\Models\Location', 'parent_location_id', 'id');
    }

    /**
     * Parent Location
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'parent_location_id', 'id');
    }

    /**
     *
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character', 'location_id', 'id');
    }

    /**
     */
    public function races()
    {
        return $this->belongsToMany('App\Models\Race', 'race_location');
    }

    /**
     */
    public function creatures()
    {
        return $this->belongsToMany('App\Models\Creature', 'creature_location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationAttributes()
    {
        return $this->hasMany('App\Models\LocationAttribute', 'location_id', 'id');
    }

    /**
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maps()
    {
        return $this->hasMany('App\Models\Map', 'location_id', 'id')
            ->select(['id', 'name']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany('App\Models\Location', 'parent_location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'location_id', 'id');
    }

    /**
     * Get all characters in the location and descendants
     */
    public function allCharacters()
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        };

        $table = new Character();
        return Character::whereIn($table->getTable() . '.location_id', $locationIds)->with('location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->hasMany('App\Models\Family', 'location_id', 'id');
    }

    /**
     * Get all families in the location and descendants
     */
    public function allFamilies()
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        };

        $table = new Family();
        return Family::whereIn($table->getTable() . '.location_id', $locationIds)->with('location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany('App\Models\Journal', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation', 'location_id', 'id');
    }

    /**
     * Get all characters in the location and descendants
     */
    public function allOrganisations()
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        };

        return Organisation::whereIn('location_id', $locationIds)->with('location');
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setParentLocationIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->characters as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->locations as $child) {
            $child->parent_location_id = null;
            $child->save();
        }

        foreach ($this->organisations as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->families as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->items as $child) {
            $child->location_id = null;
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

        $count = $this->descendants()->has('location')->count();
        if ($count > 0) {
            $items['second']['locations'] = [
                'name' => 'entities.locations',
                'route' => 'entities.descendants',
                'count' => $count,
                'entity' => true,
            ];
        }

        $count = $this->allCharacters()->count();
        if ($campaign->enabled('characters') && $count > 0) {
            $items['second']['characters'] = [
                'name' => 'entities.characters',
                'route' => 'locations.characters',
                'count' => $count,
            ];
        }
        /*$count = $this->events()->count();
        if ($campaign->enabled('events') && $count > 0) {
            $items['second']['events'] = [
                'name' => 'locations.show.tabs.events',
                'route' => 'locations.events',
                'count' => $count
            ];
        }*/
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.location');
    }

    /**
     * If the profile is shown
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        return  !empty($this->type) || !$this->maps->isEmpty() || !$this->entity->elapsedEvents->isEmpty();
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'parent_location_id',
        ];
    }
}
