<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Facades\CharacterCache;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Services\Characters\AppearanceService;
use App\Services\Characters\OrganisationService;
use App\Services\Characters\PersonalityService;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Character
 *
 * @property string $title
 * @property string $age
 * @property string $sex
 * @property string $pronouns
 * @property bool|int $is_dead
 * @property bool|int $is_personality_visible
 * @property bool|int $is_appearance_pinned
 * @property bool|int $is_personality_pinned
 * @property Collection|CharacterFamily[] $characterFamilies
 * @property Collection|Family[] $families
 * @property ?Location $location
 * @property ?int $location_id
 * @property Collection|Race[] $races
 * @property Collection|CharacterRace[] $characterRaces
 * @property Collection|Organisation[] $organisations
 * @property Collection|OrganisationMember[] $organisationMemberships
 * @property Collection|ConversationParticipant[] $conversationParticipants
 * @property Collection|Item[] $items
 * @property Collection|DiceRoll[] $diceRolls
 * @property Collection|CharacterTrait[] $appearances
 * @property Collection|CharacterTrait[] $personality
 */
class Character extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'location_id',
        'title',
        'age',
        'sex',
        'pronouns',
        'is_private',
        'is_dead',
        'is_personality_visible',
        'is_appearance_pinned',
        'is_personality_pinned',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'title',
        'location.name',
        'age',
        'sex',
        'is_dead',
    ];

    protected array $sortable = [
        'name',
        'location.name',
        'type',
        'is_dead',
    ];

    protected array $exploreGridFields = ['is_dead'];

    /**
     * Entity type
     */
    protected string $entityType = 'character';

    /**
     * Searchable fields
     */
    protected array $searchableColumns = ['name', 'title', 'type', 'entry'];

    protected array $suggestions = [
        CharacterCache::class => 'clearSuggestion',
    ];

    public array $related = [
        AppearanceService::class,
        PersonalityService::class,
        OrganisationService::class,
    ];

    protected array $sanitizable = [
        'name',
        'sex',
        'pronouns',
        'title',
        'age',
    ];

    /**
     * Casting for order by
     *
     * @var array
     */
    protected $orderCasting = [
        'age' => 'unsigned',
    ];

    /**
     * Explicit filters
     */
    protected array $explicitFilters = [
        'sex',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'characterTraits', 'characterFamilies', 'characterRaces', 'organisationMemberships',
    ];

    /**
     * @var string[] Extra relations loaded for the API endpoint
     */
    public array $apiWith = ['characterTraits', 'characterRaces', 'characterFamilies'];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
        'is_personality_visible', // checkbox
    ];

    /**
     * Performance with for old table view of all the campaign characters
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->with([
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'characterFamilies' => function ($sub) {
                $sub->select('character_family.id', 'character_family.family_id', 'character_family.character_id');
            },
            'characterRaces' => function ($sub) {
                $sub->select('character_race.id', 'character_race.race_id', 'character_race.character_id');
            },
        ]));
    }

    /**
     * Filter for characters in a specific list of organisations
     */
    public function scopeMember(Builder $query, ?string $value, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            // If called with a param, it's being called too early and will be called later in the process
            if (! empty($value)) {
                return $query;
            }
            $query
                ->select($this->getTable() . '.*')
                ->leftJoin('organisation_member as memb', function ($join) {
                    $join->on('memb.character_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.organisation_id', null);

            if (auth()->guest() || ! auth()->user()->isAdmin()) {
                $query->where('memb.is_private', 0);
            }

            return $query;
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from organisation_member as memb where memb.character_id = ' .
                    $this->getTable() . '.id and memb.character_id = ' . ((int) $value) . ' ' . $this->subPrivacy('and memb.is_private') . ') = 0');
        }

        $ids = [$value];
        if ($filter === FilterOption::CHILDREN) {
            /** @var ?Organisation $model */
            $model = Organisation::find($value);
            if (! empty($model)) {
                $ids = [...$model->descendants->pluck('id')->toArray(), $model->id];
            }
        }
        $query
            ->select($this->getTable() . '.*')
            ->leftJoin('organisation_member as memb', function ($join) {
                $join->on('memb.character_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('memb.organisation_id', $ids);

        if (auth()->guest() || ! auth()->user()->isAdmin()) {
            $query->where('memb.is_private', 0);
        }

        return $query->distinct();
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['title', 'location_id', 'sex', 'is_dead'];
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class)
            ->orderBy('character_family.id')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    public function characterFamilies(): HasMany
    {
        return $this->hasMany(CharacterFamily::class, 'character_id')
            ->orderBy('id')
            ->has('family')
            ->has('family.entity')
            ->with([
                'family' => function ($sub) {
                    $sub->select('id', 'name', 'is_private');
                },
                'family.entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    public function characterRaces(): HasMany
    {
        return $this->hasMany(CharacterRace::class, 'character_id')
            ->orderBy('id')
            ->has('race')
            ->has('race.entity')
            ->with([
                'race' => function ($sub) {
                    $sub->select('id', 'name', 'is_private');
                },
                'race.entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    public function races(): BelongsToMany
    {
        return $this->belongsToMany(Race::class)
            ->orderBy('character_race.id')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    public function organisationMemberships(): HasMany
    {
        return $this->hasMany('App\Models\OrganisationMember', 'character_id', 'id');
    }

    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Organisation', 'organisation_member')
            ->orderBy('organisation_member.id')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }

    public function items(): HasMany
    {
        return $this->hasMany('App\Models\Item', 'character_id', 'id');
    }

    public function diceRolls(): HasMany
    {
        return $this->hasMany('App\Models\DiceRoll', 'character_id', 'id');
    }

    public function conversations(): HasManyThrough
    {
        return $this->hasManyThrough(
            'App\Models\Conversation',
            'App\Models\ConversationParticipant',
            'character_id',
            'id',
            'id',
            'conversation_id'
        );
    }

    public function conversationParticipants(): HasMany
    {
        return $this->hasMany('App\Models\ConversationParticipant', 'character_id');
    }

    public function characterTraits(): HasMany
    {
        return $this->hasMany('App\Models\CharacterTrait', 'character_id', 'id');
    }

    public function appearances()
    {
        return $this->characterTraits()->appearance()->orderBy('default_order');
    }

    public function personality()
    {
        return $this->characterTraits()->personality()->orderBy('default_order');
    }

    public function pinnedMembers()
    {
        return $this
            ->organisationMemberships()
            ->has('organisation')
            ->with(['organisation', 'organisation.entity'])
            ->whereIn('pin_id', [OrganisationMember::PIN_CHARACTER, OrganisationMember::PIN_BOTH])
            ->orderBy('role');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        foreach ($this->items as $child) {
            $child->character_id = null;
            $child->saveQuietly();
        }
        foreach ($this->diceRolls as $child) {
            $child->character_id = null;
            $child->saveQuietly();
        }

        $this->organisations()->detach();
        $this->races()->detach();
        $this->families()->detach();
    }

    /**
     * Tooltip subtitle (character title)
     */
    public function tooltipSubtitle(): string
    {
        if (empty($this->title)) {
            return '';
        }

        return strip_tags($this->title);
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.character');
    }

    /**
     * Determine if the character has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        // Test text fields first
        if (! empty($this->age) || ! empty($this->sex) || ! empty($this->pronouns)) {
            return true;
        }
        if ($this->characterRaces->isNotEmpty() || $this->characterFamilies->isNotEmpty()) {
            return true;
        }
        if ($this->entity->elapsedEvents->isNotEmpty()) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Determine if the character has an age. 0 counts as a valide age.
     */
    public function hasAge(): bool
    {
        return ! empty($this->age) || $this->age === '0';
    }

    /**
     * Row classes for entities
     */
    public function rowClasses(): string
    {
        $classes = parent::rowClasses();
        if (! $this->isDead()) {
            return $classes;
        }

        return $classes . ' character-dead';
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'title',
            'age',
            'sex',
            'pronouns',
            'location_id',
            'locations',
            'organisations',
            'races',
            'families',
            'is_dead',
            'member_id',
            'race_id',
            'family_id',
            'races',
        ];
    }

    /**
     * Available sorting on the grid view
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
            'type' => __('crud.fields.type'),
            'title' => __('characters.fields.title'),
            'sex' => __('characters.fields.sex'),
            'is_dead' => __('characters.fields.is_dead'),
            'location.name' => __('entities.location'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }

        return $columns;
    }

    /**
     * Get the value of the is_dead variable
     */
    public function isDead(): bool
    {
        return (bool) $this->is_dead;
    }

    public function scopeFilteredCharacters(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query
            ->select(['id', 'name', 'title', 'location_id', 'is_dead', 'is_private'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'location', 'location.entity',
                'characterRaces',
                'characterFamilies',
                'entity', 'entity.tags', 'entity.tags.entity', 'entity.image'])
            ->has('entity');
    }
}
