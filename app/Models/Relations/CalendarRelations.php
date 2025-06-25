<?php

namespace App\Models\Relations;

use App\Models\Calendar;
use App\Models\CalendarWeather;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property Collection|Reminder[] $calendarEvents
 * @property Collection|CalendarWeather[] $calendarWeather
 * @property ?Calendar $calendar
 */
trait CalendarRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Reminder, $this>
     */
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(Reminder::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CalendarWeather, $this>
     */
    public function calendarWeather(): HasMany
    {
        return $this->hasMany(CalendarWeather::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Calendar, $this>
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Calendar, $this>
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }
}
