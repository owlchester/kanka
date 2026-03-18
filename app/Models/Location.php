<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property Map[]|Collection $maps
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
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'is_private',
        'is_destroyed',
        'title',
    ];

    protected array $sortable = [
        'name',
        'type',
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
    ];

    protected array $exportFields = [
        'base',
        'title',
        'is_destroyed',
    ];

    protected array $exploreGridFields = ['is_destroyed'];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query)
            ->withCount(['entities as characters_count' => function ($sub) {
                $sub->where('type_id', config('entities.ids.character'));
            }]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['is_destroyed'];
    }

    /**
     * @return BelongsToMany<Race, $this>
     */
    public function races(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Race', 'race_location');
    }

    /**
     * @return BelongsToMany<Creature, $this>
     */
    public function creatures(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Creature', 'creature_location');
    }

    /**
     * @return BelongsToMany<Entity, $this>
     */
    public function entities(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Entity', 'entity_locations');
    }

    /**
     * @return HasMany<Item, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany('App\Models\Item', 'location_id', 'id');
    }

    /**
     * @return HasMany<Map, $this>
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
     * Get all events in the location and descendants
     */
    public function allEvents(): Builder|Event
    {
        $locationIds = [$this->id];
        foreach ($this->entity->descendants as $descendant) {
            $locationIds[] = $descendant->entity_id;
        }

        return Event::distinct()
            ->join('entities', function ($join) {
                $join
                    ->on('entities.entity_id', '=', 'events.id')
                    ->where('entities.type_id', config('entities.ids.event'));
            })
            ->join('entity_locations as all_el', 'all_el.entity_id', '=', 'entities.id')
            ->whereIn('all_el.location_id', $locationIds);
    }

    /**
     * Get all characters in the location and descendants
     */
    public function allCharacters(bool $direct = false): Builder|Character
    {
        $locationIds = [$this->id];
        if ($direct) {
            foreach ($this->entity->descendants as $descendant) {
                $locationIds[] = $descendant->entity_id;
            }
        }

        return Character::distinct()
            ->join('entities', function ($join) {
                $join
                    ->on('entities.entity_id', '=', 'characters.id')
                    ->where('entities.type_id', config('entities.ids.character'));
            })
            ->join('entity_locations', 'entity_locations.entity_id', '=', 'entities.id')
            ->whereIn('entity_locations.location_id', $locationIds);
    }

    /**
     * Get all quests in the location and descendants
     */
    public function allQuests(): Builder|Quest
    {
        $locationIds = [$this->id];
        foreach ($this->entity->descendants as $descendant) {
            $locationIds[] = $descendant->entity_id;
        }

        $table = new Quest;

        return Quest::whereIn($table->getTable() . '.location_id', $locationIds)
            ->with('location')
            ->has('entity');
    }

    /**
     * @return HasMany<Family, $this>
     */
    public function families(): HasMany
    {
        return $this->hasMany('App\Models\Family', 'location_id', 'id');
    }

    /**
     * @return HasMany<Journal, $this>
     */
    public function journals(): HasMany
    {
        return $this->hasMany('App\Models\Journal', 'location_id', 'id');
    }

    /**
     * @return BelongsToMany<Organisation, $this>
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
        $this->entities()->delete();
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
            'is_destroyed',
        ];
    }
}
