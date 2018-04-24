<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;

class Event extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'date',
        'history',
        'is_private',
        'location_id'
    ];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = ['name', 'type', 'date', 'location_id'];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'event';

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'history', 'type'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
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
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->calendarEvents as $child) {
            $child->delete();
        }

        return parent::detach();
    }
}
