<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stevebauman\Purify\Facades\Purify;

/**
 * Class Character
 * @package App\Models
 * @property string $title
 * @property string $age
 * @property string $sex
 * @property bool $is_dead
 * @property Family $family
 * @property Location $location
 * @property Race $race
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
        'family_id',
        'location_id',
        'title',
        'entry',
        'age',
        'sex',
        'image',
        'is_private',
        'type',
        'is_dead',
        'race_id',
        'is_personality_visible',
    ];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'title',
        'age',
        'sex',
        'location_id',
        'family_id',
        'type',
        'is_dead',
        'is_private',
        'tag_id',
        'race_id',
        'tags',
        'organisation_member',
        'has_image',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'title',
        'family.name',
        'location.name',
        'race.name',
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
        'characterTraits', 'items', 'quests',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'family_id',
        'race_id',
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
            'location',
            'location.entity',
            'family',
            'family.entity',
            'race',
            'race.entity',
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
    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function race()
    {
        return $this->belongsTo('App\Models\Race', 'race_id', 'id');
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
    public function menuItems($items = [])
    {
        $campaign = CampaignLocalization::getCampaign();
        $canEdit = auth()->check() && auth()->user()->can('update', $this);

        $count = $this->items()->count();
        if ($campaign->enabled('items') && $count > 0) {
            $items['items'] = [
                'name' => 'characters.show.tabs.items',
                'route' => 'characters.items',
                'count' => $count
            ];
        }

        $count = $this->organisations()->has('organisation')->count();
        if ($campaign->enabled('organisations') && ($count > 0 || $canEdit)) {
            $items['organisations'] = [
                'name' => 'characters.show.tabs.organisations',
                'route' => 'characters.organisations',
                'count' => $count
            ];
        }
        $count = $this->journals()->count();
        if ($campaign->enabled('journals') && $count > 0) {
            $items['journals'] = [
                'name' => 'characters.show.tabs.journals',
                'route' => 'characters.journals',
                'count' => $count
            ];
        }
        $questCount = $this->relatedQuests()->count() + $this->questGiver()->count();
        if ($campaign->enabled('quests') && $questCount > 0) {
            $items['quests'] = [
                'name' => 'characters.show.tabs.quests',
                'route' => 'characters.quests',
                'count' => $questCount
            ];
        }
        $diceRollCount = $this->diceRolls()->count();
        if ($campaign->enabled('dice_rolls') && $diceRollCount > 0) {
            $items['dice_rolls'] = [
                'name' => 'characters.show.tabs.dice_rolls',
                'route' => 'characters.dice_rolls',
                'count' => $diceRollCount
            ];
        }
        $conversationCount = $this->conversations()->count();
        if ($campaign->enabled('conversations') && $conversationCount > 0) {
            $items['conversations'] = [
                'name' => 'characters.show.tabs.conversations',
                'route' => 'characters.conversations',
                'count' => $conversationCount
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
        if (!empty($this->family) && !CampaignLocalization::getCampaign()->tooltip_family) {
            $str .= ' - ' . $this->family->name;
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
}
