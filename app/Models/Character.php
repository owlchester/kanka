<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
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
 * @property Family[] $families
 * @property Location $location
 * @property Race $race
 * @property Race[] $races
 */
class Character extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        SimpleSortableTrait,
        SoftDeletes;

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
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'title',
        'age',
        'sex',
        'pronouns',
        'location_id',
        'is_dead',
        'name',
        'organisation_member',
        'attributes',
        'race',
        'family',
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
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
            'entity.image',
            'location',
            'location.entity',
            'families',
            'families.entity',
            'races',
            'races.entity',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function families()
    {
        return $this->belongsToMany('App\Models\Family')
            ->orderBy('character_family.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function races()
    {
        return $this->belongsToMany('App\Models\Race')
            ->orderBy('character_race.id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\OrganisationMember', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quests()
    {
        return $this->belongsToMany('App\Models\Quest', 'quest_characters')
            ->using('App\Models\Pivots\QuestCharacter')
            ->withPivot('role', 'is_private');
    }

    /**
     * @return mixed
     */
    public function relatedQuests()
    {
        $query = $this->quests()
            ->with(['characters', 'locations', 'quests']);

        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $query->where('quest_characters.is_private', false);
        }

        return $query;
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
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Relations\HasMany[]|OrganisationMember
     */
    public function pinnedMembers()
    {
        return $this
            ->organisations()
            ->has('organisation')
            ->with(['organisation', 'organisation.entity'])
            ->whereIn('pin_id', [OrganisationMember::PIN_CHARACTER, OrganisationMember::PIN_BOTH])
            ->orderBy('role')
            ->get()
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
                'icon' => 'fa fa-pencil',
                'tooltip' => __('crud.edit'),
            ] : null,
        ];

        $count = $this->organisations()->has('organisation')->count();
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
     * Tooltip name
     * @return string
     */
    public function tooltipName(): string
    {
        // e() isn't enough, remove tags too to avoid ><script injections.
        $str = $this->name;
        if (!empty($this->families) && !CampaignLocalization::getCampaign()->tooltip_family) {
            $families = [];
            foreach ($this->families as $family) {
                $families[] = $family->name;
            }
            $str .= ' - ' . implode(', ', $families);
        }
        return e(strip_tags(trim($str))) . ($this->is_dead ? ' <i class=\'ra ra-skull\'></i>' : null);
    }

    /**
     * Tooltip subtitle (character title)
     * @return string
     */
    public function tooltipSubtitle(): string
    {
        if (!empty($this->title)) {
            return e(strip_tags($this->title));
        }
        return '';
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
     * Determine if the appearance tab should be shown
     * @return bool
     */
    public function showAppearance(): bool
    {
        if ($this->showAppearanceCache === null) {
            $this->showAppearanceCache = !empty($this->age) || !empty($this->sex) ||
                $this->entity->elapsedEvents->count() > 0 ||
                $this->characterTraits()->appearance()->count() > 0;
        }
        return $this->showAppearanceCache;
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
}
