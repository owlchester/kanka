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
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Event
 *
 * @property ?int $event_id
 * @property string $date
 * @property Event[] $descendants
 */
class Event extends MiscModel
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
        'campaign_id',
        'name',
        'date',
        'is_private',
        'location_id',
        'event_id',
    ];

    protected array $sortable = [
        'name',
        'date',
        'parent.name',
        'type',
    ];

    protected string $entityType = 'event';

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'date',
        'location.name',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'location_id',
        'event_id',
    ];

    protected array $exportFields = [
        'base',
        'date',
        'location_id',
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
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'entity.calendarDateEvents',
        ]));
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['location_id', 'event_id', 'date'];
    }

    public function scopeFilteredEvents(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query
            ->select(['id', 'name', 'date', 'location_id', 'is_private'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'location', 'location.entity',
                'parent', 'parent.entity',
                'entity', 'entity.tags', 'entity.tags.entity', 'entity.image'])
            ->has('entity');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.event');
    }

    public function getParentKeyName()
    {
        return 'event_id';
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->type)) {
            return true;
        }

        if ($this->location || ! empty($this->entity->calendarReminder())) {
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
            'location_id',
            'event_id',
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
            'date' => __('events.fields.date'),
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $columns['is_private'] = __('crud.fields.is_private');
        }

        return $columns;
    }
}
