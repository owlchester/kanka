<?php

namespace App\Models\Relations;

use App\Models\Calendar;
use App\Models\CalendarEra;
use App\Models\CalendarWeather;
use App\Models\Reminder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property Collection|Reminder[] $calendarEvents
 * @property Collection|CalendarWeather[] $calendarWeather
 * @property Collection|CalendarEra[] $calendarEras
 * @property ?Calendar $calendar
 */
trait CalendarRelations
{
    /**
     * @return HasMany<Reminder, $this>
     */
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(Reminder::class, 'calendar_id');
    }

    /**
     * @return HasMany<CalendarWeather, $this>
     */
    public function calendarWeather(): HasMany
    {
        return $this->hasMany(CalendarWeather::class, 'calendar_id');
    }

    /**
     * @return HasMany<CalendarEra, $this>
     */
    public function calendarEras(): HasMany
    {
        return $this->hasMany(CalendarEra::class, 'calendar_id');
    }

    /**
     * @return BelongsTo<Calendar, $this>
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * @return HasMany<Calendar, $this>
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }
}
