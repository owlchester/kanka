<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
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
    use Acl
    ;
    use CalendarDateTrait;
    use CampaignTrait;
    use ExportableTrait;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

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
            'quests',
            'children' => function ($sub) {
                $sub->select('id', 'quest_id');
            }
        ]);
    }

    /**
     * Filter quests on specific elements (entities)
     * @param Builder $query
     * @param string|null $value
     * @param FilterOption $filter
     * @return Builder
     */
    public function scopeElement(Builder $query, string|null $value, FilterOption $filter): Builder
    {
        // "none" filter keys is handled later
        if ($filter === FilterOption::NONE) {
            if (!empty($value)) {
                return $query;
            }
            return $query
                ->select($this->getTable() . '.*')
                ->leftJoin('quest_elements as qe2', function ($join) {
                    $join->on('qe2.quest_id', '=', $this->getTable() . '.id');
                })
                ->where('qe2.entity_id', null);
        } elseif ($filter === FilterOption::EXCLUDE) {
            return $query
                ->whereRaw('(select count(*) from quest_elements as qe where qe.quest_id = ' .
                    $this->getTable() . '.id and qe.entity_id = ' . ((int) $value) . ') = 0');
        }
        $ids = [$value];
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('quest_elements as qe', function ($join) {
                $join->on('qe.quest_id', '=', $this->getTable() . '.id');
            })->whereIn('qe.entity_id', $ids)->distinct();
    }

    /**
     * Filter quests on specific element roles
     * @param Builder $query
     * @param string $value
     * @param string $operator
     * @return Builder
     */
    public function scopeElementRole(Builder $query, string $value, string $operator): Builder
    {
        // No attribute with this name
        if ($operator === 'not like') {
            return $query
                ->whereRaw('(select count(*) from quest_elements as qe where qe.quest_id =' . $this->getTable() . '.id and qe.role = \''
                    . ltrim($value, '!') . '\') = 0');
        }
        return $query
            ->select($this->getTable() . '.*')
            ->leftJoin('quest_elements as qe', function ($join) {
                $join->on('qe.quest_id', '=', $this->getTable() . '.id');
            })
            ->where('qe.role', $value);
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
        return $this->belongsTo(Quest::class);
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
        return $this->hasMany(Quest::class);
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setQuestIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Parent ID field for the Node trait
     * @return string
     */
    public function getParentIdName()
    {
        return 'quest_id';
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
            'quest_element_id',
            'element_role',
        ];
    }

    /**
     * Get the value of the is_complete variable
     * @return bool
     */
    public function isCompleted(): bool
    {
        return (bool) $this->is_completed;
    }
}
