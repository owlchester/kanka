<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Journal
 *
 * @property int $id
 * @property string $date
 * @property ?int $character_id
 * @property ?int $journal_id
 * @property ?int $author_id
 * @property ?Character $character
 * @property ?Entity $author
 * @property Journal[] $descendants
 */
class Journal extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'name',
        'campaign_id',
        'date',
        'character_id',
        'location_id',
        'is_private',
        'journal_id',
        'author_id',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'journal';

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'date',
        'calendar_date',
        'author.name',
    ];

    protected array $sortable = [
        'name',
        'date',
        'character.name',
        'parent.name',
        'type',
        // 'character.name',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
        // 'character_id',
        'calendar_id',
        'journal_id',
        'author_id',
    ];

    protected array $apiWith = [
        'author',
        'entity.calendarDate',
    ];

    public array $exportFields = [
        'base',
        'author_id',
        'location_id',
        'date',
    ];

    protected array $sanitizable = [
        'name',
        'date',
    ];

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query->with([
            'entity.calendarDate',
            'entity.calendarDate.calendar',
            'entity.calendarDate.calendar.entity',
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'author' => function ($sub) {
                $sub->select('id', 'name');
            },
        ]));
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['journal_id', 'author_id', 'date'];
    }

    /**
     * Get all journals in the journal and descendants
     */
    public function allJournals()
    {
        $locationIds = [$this->id];
        foreach ($this->descendants as $descendant) {
            $locationIds[] = $descendant->id;
        }

        $table = new Journal;

        return Journal::whereIn($table->getTable() . '.journal_id', $locationIds)
            ->has('entity')
            ->with('parent');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Character, $this>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'author_id');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.journal');
    }

    /**
     * Parent ID field for the Node trait
     *
     * @return string
     */
    public function getParentKeyName()
    {
        return 'journal_id';
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->date)) {
            return true;
        }

        if (! empty($this->author) || ! empty($this->location)) {
            return true;
        }
        if (! empty($this->entity->calendarReminder())) {
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
            'character_id',
            'location_id',
            'journal_id',
            'author_id',
            'date_start',
            'date_end',
        ];
    }

    /**
     * Grid mode sortable fields
     */
    public function datagridSortableColumns(): array
    {
        $columns = [
            'name' => __('crud.fields.name'),
            'type' => __('crud.fields.type'),
            'date' => __('journals.fields.date'),
            'calendar_date' => __('crud.fields.calendar_date'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }

        return $columns;
    }
}
