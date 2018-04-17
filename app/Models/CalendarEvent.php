<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\VisibleTrait;

class CalendarEvent extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * @var string
     */
    public $table = 'calendar_event';

    /**
     * @var array
     */
    protected $fillable = ['calendar_id', 'event_id', 'date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id');
    }
}
