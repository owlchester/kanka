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
 * @property QuestElement[] $elements
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
        'date',
        'quest_id',
        'character_id',
        'is_completed',
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
            'entity.image',
            'quests',
            'character',
            'character.entity',
            //'elements',
            'quest',
            'quest.entity',

            'calendar',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(QuestElement::class);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->elements as $child) {
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
    public function menuItems(array $items = []): array
    {
        $campaign = CampaignLocalization::getCampaign();

        $count = $this->elements()->with('entity')->has('entity')->count();
        $items['second']['elements'] = [
            'name' => 'quests.show.tabs.elements',
            'route' => 'quests.quest_elements.index',
            'count' => $count
        ];
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

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        return !empty($this->type) || !empty($this->character);
    }
}
