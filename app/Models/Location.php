<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
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
 *
 * @property string $name
 * @property string $type
 * @property string $image
 * @property ?string $map
 * @property bool|int $is_private
 * @property bool|int $is_destroyed
 * @property bool|int $is_map_private
 * @property ?int $location_id
 * @property Map[]|Collection $maps
 * @property ?Location $parent
 * @property Location[]|Collection $descendants
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
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'location_id',
        'campaign_id',
        'is_private',
        'is_destroyed',
    ];

    protected array $sortable = [
        'name',
        'type',
        'parent.name',
        'is_destroyed',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'is_destroyed',
    ];

    /**
     * Nullable values (foreign keys)
     */
    public array $nullableForeignKeys = [
        'location_id',
    ];

    protected array $exportFields = [
        'base',
        'is_destroyed',
    ];

    protected array $exploreGridFields = ['is_destroyed'];

    protected array $sanitizable = [
        'name',
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
        return parent::scopePreparedWith($query)
            ->withCount('characters');
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['location_id', 'is_destroyed'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany('App\Models\Character', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Race, $this>
     */
    public function races(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Race', 'race_location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Creature, $this>
     */
    public function creatures(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Creature', 'creature_location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Entity, $this>
     */
    public function entities(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Entity', 'entity_locations');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Item, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany('App\Models\Item', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Map, $this>
     */
    public function maps(): HasMany
    {
        return $this->hasMany('App\Models\Map', 'location_id', 'id')
            ->with('entity')
            ->with('entity.image')
            ->has('entity')
            ->select(['id', 'name', 'is_real']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Event, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany('App\Models\Event', 'location_id', 'id');
    }

    /**
     * Get all events in the location and descendants
     */
    public function allEvents(): Builder|Event
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        }

        $table = new Event;

        return Event::whereIn($table->getTable() . '.location_id', $locationIds)
            ->with('location')
            ->has('entity');
    }

    /**
     * Get all characters in the location and descendants
     */
    public function allCharacters(): Builder|Character
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        }

        $table = new Character;

        return Character::whereIn($table->getTable() . '.location_id', $locationIds)
            ->with('location')
            ->has('entity');
    }

    /**
     * Get all quests in the location and descendants
     */
    public function allQuests(): Builder|Quest
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        }

        $table = new Quest;

        return Quest::whereIn($table->getTable() . '.location_id', $locationIds)
            ->with('location')
            ->has('entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Family, $this>
     */
    public function families(): HasMany
    {
        return $this->hasMany('App\Models\Family', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Journal, $this>
     */
    public function journals(): HasMany
    {
        return $this->hasMany('App\Models\Journal', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\Organisation, $this>
     */
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
        if ($this->maps->isNotEmpty() || $this->entity->elapsedEvents->isNotEmpty()) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Get the value of the is_destroyed variable
     */
    public function isDestroyed(): bool
    {
        return (bool) $this->is_destroyed;
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
            'is_destroyed',
        ];
    }
}
