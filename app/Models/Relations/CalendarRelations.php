<?php

namespace App\Models\Relations;

use App\Models\Calendar;
use App\Models\CalendarWeather;
use App\Models\EntityEvent;

/**
 * @property EntityEvent[] $calendarEvents
 * @property CalendarWeather[] $calendarWeather
 * @property Calendar|null $calendar
 */
trait CalendarRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarEvents()
    {
        return $this->hasMany(EntityEvent::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarWeather()
    {
        return $this->hasMany(CalendarWeather::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
}
