<?php

namespace App\Models\Relations;

use App\Models\Calendar;
use App\Models\CalendarWeather;
use App\Models\EntityEvent;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property EntityEvent[] $calendarEvents
 * @property CalendarWeather[] $calendarWeather
 * @property Calendar|null $calendar
 */
trait CalendarRelations
{
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(Reminder::class, 'calendar_id');
    }

    public function calendarWeather(): HasMany
    {
        return $this->hasMany(CalendarWeather::class, 'calendar_id');
    }

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }
}
