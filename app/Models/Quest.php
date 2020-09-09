<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CalendarDateTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Quest
 * @package App\Models
 * @property integer $quest_id
 * @property integer $character_id
 * @property boolean $is_completed
 * @property string $date
 * @property Character $character
 * @property Character[] $characters
 * @property Location[] $locations
 * @property Quest $quest
 * @property Quest[] $quests
 * @property Item[] $items
 * @property Organisation[] $organisations
 */
class Quest extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        CalendarDateTrait,
        SimpleSortableTrait,
        SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'quest_id',
        'name',
        'slug',
        'type',
        'entry',
        'is_private',
        'character_id',
        'is_completed',
        'date',

        // calendar date
        'calendar_id',
        'calendar_year',
        'calendar_month',
        'calendar_day',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'quest';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'date',
        'quest_id',
        'tag_id',
        'character_id',
        'is_completed',
        'is_private',
        'tags',
        'has_image',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'date',
        'character.name',
        'is_completed',
        'calendar_date',
        'quest.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'character_id',
        'quest_id',
        'calendar_id'
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'entry'];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'locations',
        'characters',
        'items',
        'organisations',
    ];

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with([
            'entity',
            'quests',
            'locations',
            'characters',
            'organisations',
            'quest',
            'quest.entity',
        ]);
    }

    /**
     * Parent
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id', 'id');
    }

    /**
     * @return mixed
     */
    public function shortDescription()
    {
        return $this->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locations()
    {
        return $this->hasMany('App\Models\QuestLocation', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function characters()
    {
        return $this->hasMany('App\Models\QuestCharacter', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function items()
    {
        return $this->hasMany('App\Models\QuestItem', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\QuestOrganisation', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quests()
    {
        return $this->hasMany('App\Models\Quest', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->locations as $child) {
            $child->delete();
        }
        foreach ($this->characters as $child) {
            $child->delete();
        }
        foreach ($this->items as $child) {
            $child->delete();
        }
        foreach ($this->organisations as $child) {
            $child->delete();
        }
        foreach ($this->quests as $quest) {
            $quest->quest_id = null;
            $quest->save();
        }
        return parent::detach();
    }

    /**
     * @return array
     */
    public function menuItems($items = [])
    {
        $campaign = CampaignLocalization::getCampaign();

        if ($campaign->enabled('characters')) {
            $count = $this->characters()->with('character')->has('character')->count();
            $items['characters'] = [
                'name' => 'quests.show.tabs.characters',
                'route' => 'quests.characters',
                'count' => $count
            ];
        }
        if ($campaign->enabled('locations')) {
            $count = $this->locations()->with('location')->has('location')->count();
            $items['locations'] = [
                'name' => 'quests.show.tabs.locations',
                'route' => 'quests.locations',
                'count' => $count
            ];
        }
        if ($campaign->enabled('items')) {
            $count = $this->items()->with('item')->has('item')->count();
            $items['items'] = [
                'name' => 'quests.show.tabs.items',
                'route' => 'quests.items',
                'count' => $count
            ];
        }
        if ($campaign->enabled('organisations')) {
            $count = $this->organisations()->with('organisation')->has('organisation')->count();
            $items['organisations'] = [
                'name' => 'quests.show.tabs.organisations',
                'route' => 'quests.organisations',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.quest');
    }
}
