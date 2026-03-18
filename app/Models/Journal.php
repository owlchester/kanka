<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasLocation;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Journal
 *
 * @property int $id
 * @property string $date
 * @property ?int $character_id
 * @property ?int $author_id
 * @property ?Character $character
 * @property ?Entity $author
 */
class Journal extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasLocation;
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
        'author_id',
    ];

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
     * Get all journals in the journal and descendants
     */
    public function allJournals()
    {
        $entityIds = [$this->entity->id];
        foreach ($this->entity->descendants as $descendant) {
            $entityIds[] = $descendant->id;
        }

        return Journal::whereHas('entity', fn ($q) => $q->whereIn('entities.parent_id', $entityIds))
            ->has('entity')
            ->with('entity.parent');
    }

    /**
     * @return BelongsTo<Character, $this>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     * @return BelongsTo<Entity, $this>
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
