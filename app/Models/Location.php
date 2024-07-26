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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Location
 * @package App\Models
 * @property string $name
 * @property string $type
 * @property string $image
 * @property string|null $map
 * @property bool|int $is_private
 * @property bool|int $is_map_private
 * @property int|null $location_id
 * @property Map[]|Collection $maps
 * @property Location[]|Collection $descendants
 * @property Location[]|Collection $locations
 * @property Event[]|Collection $events
 * @property Character[]|Collection $characters
 * @property Organisation[]|Collection $organisations
 * @property Creature[]|Collection $creatures
 * @property Race[]|Collection $races
 * @property Family[]|Collection $families
 * @property Item[]|Collection $items
 */
class Location extends MiscModel
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

    protected $fillable = [
        'name',
        'slug',
        'type',
        'entry',
        'location_id',
        'campaign_id',
        'is_private',
    ];


    protected array $sortable = [
        'name',
        'type',
        'parent.name',
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
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
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

    public function races(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Race', 'race_location');
    }

    public function creatures(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Creature', 'creature_location');
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
            ->has('entity')
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
     * Get all events in the location and descendants
     */
    public function allEvents(): Builder
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        };

        $table = new Event();
        return Event::whereIn($table->getTable() . '.location_id', $locationIds)
            ->with('location')
            ->has('entity');
    }

    /**
     * Get all characters in the location and descendants
     */
    public function allCharacters(): Builder
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

    public function families(): HasMany
    {
        return $this->hasMany('App\Models\Family', 'location_id', 'id');
    }

    /**
     * Get all families in the location and descendants
     */
    public function allFamilies(): Builder
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        };

        $table = new Family();
        return Family::whereIn($table->getTable() . '.location_id', $locationIds)->with('location');
    }

    public function journals(): HasMany
    {
        return $this->hasMany('App\Models\Journal', 'location_id', 'id');
    }

    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Organisation', 'organisation_location');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        foreach ($this->characters as $child) {
            $child->location_id = null;
            $child->saveQuietly();
        }

        foreach ($this->families as $child) {
            $child->location_id = null;
            $child->saveQuietly();
        }

        foreach ($this->items as $child) {
            $child->location_id = null;
            $child->saveQuietly();
        }

        // Pivot tables can be deleted directly
        $this->races()->delete();
        $this->creatures()->delete();
        $this->organisations()->delete();
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
