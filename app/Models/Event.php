<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 *
 * @property string $date
 */
class Event extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'campaign_id',
        'name',
        'date',
        'is_private',
    ];

    protected array $sortable = [
        'name',
        'date',
        'type',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'date',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
    ];

    protected array $exportFields = [
        'base',
        'date',
    ];

    protected array $sanitizable = [
        'name',
        'date',
    ];

    public function scopeFilteredEvents(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query
            ->select(['events.id', 'events.name', 'events.date', 'events.is_private'])
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity.locations', 'entity.locations.entity',
                'entity', 'entity.parent', 'entity.tags', 'entity.tags.entity', 'entity.image'])
            ->has('entity');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.event');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        if (! empty($this->type)) {
            return true;
        }

        if ($this->entity->locations->isNotEmpty() || ! empty($this->entity->calendarReminder())) {
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
            'locations',
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
