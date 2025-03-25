<?php

namespace App\Models;

use App\Enums\FilterOption;
use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\HasReminder;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Quest
 *
 * @property ?int $quest_id
 * @property ?int $instigator_id
 * @property ?int $location_id
 * @property bool|int $is_completed
 * @property string $date
 * @property ?Location $location
 * @property ?Entity $instigator
 * @property QuestElement[]|Collection $elements
 */
class Quest extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use HasRecursiveRelationships;
    use HasReminder;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'quest_id',
        'name',
        'is_private',
        'instigator_id',
        'location_id',
        'is_completed',
        'date',
    ];

    protected array $sortable = [
        'name',
        'date',
        'is_completed',
        'type',
        'parent.name',
    ];

    protected array $sanitizable = [
        'name',
        'date',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'quest';

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'date',
        'instigator.name',
        'is_completed',
        'calendar_date',
        'location.name',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'instigator_id',
        'location_id',
        'quest_id',
    ];

    /**
     * Foreign relations to add to export
     */
    protected array $foreignExport = [
        'elements',
    ];

    protected array $apiWith = [
        'entity.calendarDate',
        'elements',
    ];

    protected array $exportFields = [
        'base',
        'instigator_id',
        'location_id',
        'is_completed',
        'date',
    ];

    protected array $exploreGridFields = ['is_completed'];

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->with([
            'entity.calendarDate',
            'entity.calendarDate.calendar',
            'entity.calendarDate.calendar.entity',
            'instigator' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
        ]))
            ->withCount('elements');
    }

    public function scopeFilteredQuests(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query
            ->select(['id', 'name', 'type', 'location_id', 'is_completed', 'is_private'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'location', 'location.entity',
                'elements',
                'entity', 'entity.tags', 'entity.tags.entity', 'entity.image'])
            ->has('entity');
    }

    /**
     * Filter quests on specific elements (entities)
     */
    public function scopeElement(Builder $query, ?string $value, FilterOption $filter): Builder
    {
        // "none" filter keys is handled later
        if ($filter === FilterOption::NONE) {
            if (! empty($value)) {
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
     */
    public function scopeElementRole(Builder $query, string $value, string $operator): Builder
    {
        // No attribute with this name
        if ($operator === 'not like') {
            return $query
                ->whereRaw('(select count(*) from quest_elements as qe where qe.quest_id =' . $this->getTable() . '.id and qe.role = \''
                    . mb_ltrim($value, '!') . '\') = 0');
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
     */
    public function datagridSelectFields(): array
    {
        return ['quest_id', 'instigator_id', 'location_id', 'is_completed', 'calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'];
    }

    public function shortDescription()
    {
        return $this->name;
    }

    /**
     * Parent ID field for the Node trait
     *
     * @return string
     */
    public function getParentKeyName()
    {
        return 'quest_id';
    }

    /**
     * The Quest Giver
     */
    public function instigator(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    /**
     * The Starting location
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Elements of the quest
     */
    public function elements(): HasMany
    {
        return $this->hasMany(QuestElement::class)
            ->with(['entity', 'entity.image']);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        foreach ($this->elements as $child) {
            $child->delete();
        }
        $this->instigator_id = null;
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.quest');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if ($this->instigator ||
            ! empty($this->date) || ! empty($this->calendarReminder()) || ! empty($this->location)) {
            return true;
        }

        return parent::showProfileInfo();
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'date',
            'quest_id',
            'instigator_id',
            'is_completed',
            'date_start',
            'location_id',
            'date_end',
            'quest_element_id',
            'element_role',
        ];
    }

    /**
     * Get the value of the is_complete variable
     */
    public function isCompleted(): bool
    {
        return (bool) $this->is_completed;
    }

    /**
     * Grid mode sortable fields
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
            'type' => __('crud.fields.type'),
            'is_completed' => __('quests.fields.is_completed'),
            'calendar_date' => __('crud.fields.calendar_date'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }

        return $columns;
    }
}
