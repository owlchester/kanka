<?php

namespace App\Models;

use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Event
 * @package App\Models
 *
 * @property int $event_id
 * @property Event $event
 * @property Event[] $events
 * @property Event[] $descendants
 */
class Event extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        SoftDeletes,
        NodeTrait,
        SimpleSortableTrait;

    /**
     * @var array
     */
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

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'date',
        'location_id',
        'event_id',
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
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'event_id',
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
            'location',
            'location.entity'
        ]);
    }

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'event';

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'entry', 'type'];

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
    public function calendars()
    {
        return $this->hasManyThrough('App\Models\Calendar', 'App\Models\CalendarEvent', 'event_id', 'calendar_id');
    }

    public function calendarEvents()
    {
        return $this->hasMany('App\Models\CalendarEvent', 'event_id');
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
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->calendarEvents as $child) {
            $child->delete();
        }

        return parent::detach();
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
     * @param $value
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
            'name' => 'events.fields.events',
            'route' => 'events.events',
            'count' => $this->descendants()->count()
        ];

        return parent::menuItems($items);
    }
}
