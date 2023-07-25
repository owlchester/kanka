<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Facades\CampaignLocalization;
use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Character
 * @package App\Models
 * @property string $title
 * @property string $age
 * @property string $sex
 * @property string $pronouns
 * @property bool $is_dead
 * @property bool $is_personality_visible
 * @property bool $is_appearance_pinned
 * @property bool $is_personality_pinned
 * @property Collection|Family[] $families
 * @property Location|null $location
 * @property int|null $location_id
 * @property Race|null $race
 * @property Collection|Race[] $races
 * @property Collection|Organisation[] $organisations
 * @property Collection|OrganisationMember[] $organisationMemberships
 * @property Collection|ConversationParticipant[] $conversationParticipants
 * @property Collection|Journal[] $journals
 * @property Collection|Item[] $items
 */
class Character extends MiscModel
{
    use Acl
    ;
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'location_id',
        'title',
        'entry',
        'age',
        'sex',
        'pronouns',
        'image',
        'is_private',
        'type',
        'is_dead',
        'is_personality_visible',
        'is_appearance_pinned',
        'is_personality_pinned',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'title',
        'location.name',
        'age',
        'sex',
        'is_dead'
    ];
    protected $sortable = [
        'name',
        'type',
        'location.name',
        'is_dead',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'character';

    /**
     * Searchable fields
     * @var array
     */
    protected array $searchableColumns = ['name', 'title', 'type', 'entry'];

    /**
     * Casting for order by
     * @var array
     */
    protected $orderCasting = [
        'age' => 'unsigned'
    ];

    /**
     * Explicit filters
     * @var array
     */
    protected $explicitFilters = [
        'sex'
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'characterTraits', 'families', 'races'
    ];

    /**
     * @var string[] Extra relations loaded for the API endpoint
     */
    public $apiWith = ['characterTraits'];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'location_id',
        'is_personality_visible', // checkbox
    ];

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'families' => function ($sub) {
                $sub->select('families.id', 'families.name');
            },
            'races' => function ($sub) {
                $sub->select('races.id', 'races.name');
            },
        ]);
    }
    /**
     * Filter for characters in a specific list of organisations
     * @param Builder $query
     * @param string|null $value
     * @param FilterOption $filter
     * @return Builder
     */
    public function scopeMember(Builder $query, string|null $value, FilterOption $filter): Builder
    {
        if ($filter === FilterOption::NONE) {
            // If called with a param, it's being called too early and will be called later in the process
            if (!empty($value)) {
                return $query;
            }
            return $query
                ->select($this->getTable() . '.*')
                ->leftJoin('organisation_member as memb', function ($join) {
                    $join->on('memb.character_id', '=', $this->getTable() . '.id');
                })
                ->where('memb.organisation_id', null);
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from organisation_member as memb where memb.character_id = ' .
                    $this->getTable() . '.id and memb.organisation_id in (' . (int) $value . ')) = 0');
        }

        $ids = [$value];
        if ($filter === FilterOption::CHILDREN) {
            /** @var Organisation|null $model */
            $model = Organisation::find($value);
            if (!empty($model)) {
                $ids = [...$model->descendants->pluck('id')->toArray(), $model->id];
            }
        }
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('organisation_member as memb', function ($join) {
                $join->on('memb.character_id', '=', $this->getTable() . '.id');
            })
            ->whereIn('memb.organisation_id', $ids)->distinct();
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['title', 'location_id', 'sex', 'is_dead'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this
            ->belongsTo('App\Models\Location', 'location_id', 'id')
            ->with('entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function families()
    {
        return $this->belongsToMany('App\Models\Family')
            ->orderBy('character_family.id')
            ->with('entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function races()
    {
        return $this->belongsToMany('App\Models\Race')
            ->orderBy('character_race.id')
            ->with('entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisationMemberships()
    {
        return $this->hasMany('App\Models\OrganisationMember', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organisations()
    {
        return $this->belongsToMany('App\Models\Organisation', 'organisation_member')
            ->orderBy('organisation_member.id')
            ->with('entity');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany('App\Models\Journal', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diceRolls()
    {
        return $this->hasMany('App\Models\DiceRoll', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function conversations()
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conversationParticipants()
    {
        return $this->hasMany('App\Models\ConversationParticipant', 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characterTraits()
    {
        return $this->hasMany('App\Models\CharacterTrait', 'character_id', 'id');
    }

    /**
     */
    public function pinnedMembers()
    {
        return $this
            ->organisationMemberships()
            ->has('organisation')
            ->with(['organisation', 'organisation.entity'])
            ->whereIn('pin_id', [OrganisationMember::PIN_CHARACTER, OrganisationMember::PIN_BOTH])
            ->orderBy('role')
        ;
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->journals as $child) {
            $child->character_id = null;
            $child->save();
        }

        foreach ($this->items as $child) {
            $child->character_id = null;
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
        $canEdit = auth()->check() && auth()->user()->can('update', $this);

        $items['second']['profile'] = [
            'name' => 'entities/profile.show.tab_name',
            'route' => 'entities.profile',
            'entity' => true,

            'button' => auth()->check() && auth()->user()->can('update', $this) ? [
                'url' => $this->getLink('edit'),
                'icon' => 'fa-solid fa-pencil',
                'tooltip' => __('crud.edit'),
            ] : null,
        ];

        $count = $this->organisationMemberships()->has('organisation')->count();
        if ($campaign->enabled('organisations') && ($count > 0 || $canEdit)) {
            $items['second']['organisations'] = [
                'name' => Module::plural(config('entities.ids.organisation'), 'entities.organisations'),
                'route' => 'characters.organisations',
                'count' => $count
            ];
        }

        return parent::menuItems($items);
    }

    /**
     * Tooltip subtitle (character title)
     * @return string
     */
    public function tooltipSubtitle(): string
    {
        if (empty($this->title)) {
            return '';
        }
        return e(strip_tags($this->title));
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.character');
    }

    /**
     * Determine if the character has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        // Test text fields first
        if (!empty($this->type) || !empty($this->age) || !empty($this->sex)
            || !empty($this->pronouns)) {
            return true;
        }
        if (!$this->races->isEmpty() || !$this->families->isEmpty()) {
            return true;
        }
        return (bool) (!$this->entity->elapsedEvents->isEmpty());
    }

    /**
     * Determine if the character has an age. 0 counts as a valide age.
     * @return bool
     */
    public function hasAge(): bool
    {
        return !empty($this->age) || $this->age === "0";
    }

    /**
     * Row classes for entities
     * @return string
     */
    public function rowClasses(): string
    {
        $classes = parent::rowClasses();
        if (!$this->isDead()) {
            return $classes;
        }
        return $classes . ' character-dead';
    }

    /**
     * Define the fields unique to this model that can be used on filters
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
            'is_dead',
            'member_id',
            'race_id',
            'family_id',
            'races',
        ];
    }

    /**
     * Available sorting on the grid view
     * @return array
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
            'type' => __('crud.fields.type'),
            'title' => __('characters.fields.title'),
            'sex' => __('characters.fields.sex'),
            'is_dead' => __('characters.fields.is_dead'),
            'location_id' => __('entities.location'),
            'family_id' => __('entities.family'),
            'race_id' => __('entities.race'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }
        return $columns;
    }

    /**
     * Get the value of the is_dead variable
     * @return bool
     */
    public function isDead(): bool
    {
        return (bool) $this->is_dead;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeFilteredCharacters(Builder $query): Builder
    {
        return $query
            ->select(['id', 'image', 'name', 'title', 'type','location_id', 'is_dead', 'is_private'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['location', 'location.entity', 'families', 'families.entity', 'races', 'races.entity', 'entity', 'entity.tags', 'entity.image'])
            ->has('entity');
    }
}
