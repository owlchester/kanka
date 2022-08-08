<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\Acl;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property Location $location
 * @property Race $race
 * @property Collection|Race[] $races
 * @property Collection|Organisation[] $organisations
 * @property Collection|OrganisationMember[] $organisationMemberships
 */
class Character extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        SoftDeletes,
        SortableTrait,
        Acl
    ;

    //
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
     * Hidden from export
     * @var array
     */
    protected $hidden = [
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
    protected $searchableColumns = ['name', 'title', 'entry'];

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
        'characterTraits',
    ];

    /**
     * @var string[] Extra relations loaded for the API endpoint
     */
    public $apiWith = ['characterTraits'];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'is_personality_visible', // checkbox
    ];

    protected $showAppearanceCache = null;

    /**
     * Performance with for datagrids
     * @param Builder$ query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query)
    {
        return $query->with([
            'entity',
            'entity.image',
            'location',
            'families',
            'races',
        ]);
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
        return $this->belongsTo('App\Models\Location', 'location_id', 'id')
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
     * Query to get quests where the character is the "quest giver"
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questGiver()
    {
        return $this->hasMany('App\Models\Quest', 'character_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Collection|OrganisationMember[]|Builder
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
                'name' => 'characters.show.tabs.organisations',
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
        if (!$this->entity->elapsedEvents->isEmpty()) {
            return true;
        }
        return false;
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
        if (!$this->is_dead) {
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
            'organisation_member',
            'race',
            'family',
            'races',
        ];
    }
}
