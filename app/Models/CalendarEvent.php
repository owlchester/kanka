<?php

namespace App\Models;

use App\Traits\VisibilityTrait;

/**
 * Class CalendarEvent
 * @package App\Models
 *
 * @property int $id
 * @property int $event_id
 * @property int $calendar_id
 * @property int $length
 * @property string $date
 * @property string $visibility
 *
 * @property Calendar $calendar
 */
class CalendarEvent extends MiscModel
{
    /**
     * Traits
     */
    use VisibilityTrait;

    /**
     * @var string
     */
    public $table = 'calendar_event';

    /**
     * @var array
     */
    protected $fillable = [
        'calendar_id',
        'event_id',
        'date',
        'visibility',
    ];

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
