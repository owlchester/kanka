<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

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
 * @property integer|null $location_id
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
    use Acl;
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use SoftDeletes;
    use SortableTrait;

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'entry',
        'location_id',
        'campaign_id',
        'is_private',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'location.name',
    ];

    protected array $sortable = [
        'name',
        'type',
        'location.name',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'location';

    /**
     * Nullable values (foreign keys)
     */
    public array $nullableForeignKeys = [
        'location_id',
    ];

    protected array $exportFields = [
        'base',
    ];

    public function getParentKeyName()
    {
        return 'location_id';
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
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'children' => function ($sub) {
                $sub->select('id', 'location_id');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'locations' => function ($sub) {
                $sub->select('id', 'location_id');
            },
            'characters' => function ($sub) {
                $sub->select('id', 'location_id');
            },
            'races'
        ]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['location_id'];
    }

    /**
     * Parent Location
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function characters(): HasMany
    {
        return $this->hasMany('App\Models\Character', 'location_id', 'id');
    }

    public function races(): HasMany
    {
        return $this->belongsToMany('App\Models\Race', 'race_location');
    }

    public function creatures(): HasMany
    {
        return $this->belongsToMany('App\Models\Creature', 'creature_location');
    }

    public function locationAttributes(): HasMany
    {
        return $this->hasMany('App\Models\LocationAttribute', 'location_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany('App\Models\Item', 'location_id', 'id');
    }

    public function maps(): HasMany
    {
        return $this->hasMany('App\Models\Map', 'location_id', 'id')
            ->with('entity')
            ->with('entity.image')
            ->select(['id', 'name', 'is_real']);
    }

    public function locations(): HasMany
    {
        return $this->hasMany('App\Models\Location', 'location_id', 'id');
    }

    public function events(): HasMany
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
        return Character::whereIn($table->getTable() . '.location_id', $locationIds)
            ->with('location')
            ->has('entity');
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
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->characters as $child) {
            $child->location_id = null;
            $child->save();
        }

        foreach ($this->locations as $child) {
            $child->location_id = null;
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
     */
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $count = $this->descendants()->has('location')->count();
        if ($count > 0) {
            $items['second']['locations'] = [
                'name' => Module::plural($this->entityTypeId(), 'entities.locations'),
                'route' => 'locations.locations',
                'count' => $count
            ];
        }

        $count = $this->allCharacters()->count();
        if ($campaign->enabled('characters') && $count > 0) {
            $items['second']['characters'] = [
                'name' => Module::plural(config('entities.ids.character'), 'entities.characters'),
                'route' => 'locations.characters',
                'count' => $count
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
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.location');
    }

    /**
     * If the profile is shown
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
            'location_id',
        ];
    }
}
