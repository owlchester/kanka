<?php

namespace App\Models;

use App\Facades\Module;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\CalendarDateTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Event
 * @package App\Models
 *
 * @property int|null $event_id
 * @property int|null $location_id
 * @property string $date
 * @property Location|null $location
 * @property Event|null $event
 * @property Event[] $events
 * @property Event[] $descendants
 */
class Event extends MiscModel
{
    use Acl
    ;
    use CalendarDateTrait;
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use Nested;
    use SoftDeletes;
    use SortableTrait;

    /** @var string[]  */
    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'image',
        'date',
        'entry',
        'is_private',
        'location_id',
        'event_id',
    ];

    protected $sortable = [
        'name',
        'date',
        'type',
        'event.name',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected $sortableColumns = [
        'date',
        'location.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'location_id',
        'event_id',
    ];

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'location' => function ($sub) {
                $sub->select('id', 'name');
            },
            'location.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'event' => function ($sub) {
                $sub->select('id', 'name');
            },
            'event.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'descendants' => function ($sub) {
                $sub->select('id', 'name', 'event_id');
            },
            'events' => function ($sub) {
                $sub->select('id', 'name', 'event_id');
            },
            'children' => function ($sub) {
                $sub->select('id', 'event_id');
            },
            'entity.calendarDateEvents',
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['location_id', 'event_id', 'date'];
    }

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'event';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
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
    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'event_id', 'id');
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.event');
    }

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'event_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param int $value
     */
    public function setEventIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $items['second']['events'] = [
            'name' => Module::plural($this->entityTypeId(), 'entities.events'),
            'route' => 'events.events',
            'count' => $this->descendants()->count()
        ];

        return parent::menuItems($items);
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        if (!empty($this->type)) {
            return true;
        }

        return (bool) ($this->location || !empty($this->calendarReminder()));
    }

    /**
     * Define the fields unique to this model that can be used on filters
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
     * @return array
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
