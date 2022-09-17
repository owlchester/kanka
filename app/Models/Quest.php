<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\SortableTrait;
use App\Traits\CalendarDateTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Class Quest
 * @package App\Models
 * @property integer|null $quest_id
 * @property integer|null $character_id
 * @property boolean $is_completed
 * @property string $date
 * @property Character|null $character
 * @property Quest|null $quest
 * @property Quest[]|Collection $quests
 * @property QuestElement[]|Collection $elements
 */
class Quest extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        CalendarDateTrait,
        SoftDeletes,
        SortableTrait,
        Acl
    ;

    /** @var string[]  */
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

    protected $sortable = [
        'name',
        'type',
        'date',
        'is_compelted',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'quest';

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
     * @var string[]
     */
    public $nullableForeignKeys = [
        'character_id',
        'quest_id',
        'calendar_id'
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'elements',
    ];

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity',
            'entity.image',
            'entity.calendarDateEvents',
            'quests',
            'character',
            'character.entity',
            //'elements',
            'quest',
            'quest.entity',
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['quest_id', 'character_id', 'is_completed', 'calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'];
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
     */
    public function quests()
    {
        return $this->hasMany('App\Models\Quest', 'quest_id', 'id');
    }

    /**
     * The character, aka "Quest Giver"
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character');
    }

    /**
     * Elements of the quest
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
        parent::detach();
    }

    /**
     * @param array $items
     * @return array
     */
    public function menuItems(array $items = []): array
    {
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
        return !empty($this->type) || !empty($this->character) ||
            !empty($this->date) || !empty($this->calendarReminder());
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'date',
            'quest_id',
            'character_id',
            'is_completed',
            'date_start',
            'date_end',
        ];
    }
}
