<?php

namespace App\Traits;

use App\Models\Calendar;
use App\Models\EntityEvent;
use App\Models\EntityEventType;
use App\Models\MiscModel;
use App\Observers\Remindable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Trait CalendarDateTrait
 * @package App\Traits
 *
 * @property EntityEvent $calendarReminder
 * @property int|null $calendar_id
 * @property int|null $calendar_year
 * @property int|null $calendar_month
 * @property int|null $calendar_day
 */
trait CalendarDateTrait
{
    /** @var bool|null|EntityEvent */
    protected $calendarDateEvent = false;

    /**
     * On boot of the trait, inject the fillable fields.
     */
    public static function bootCalendarDateTrait()
    {
        static::observe(app(Remindable::class));
    }

    /**
     * @return bool
     */
    public function hasCalendar(): bool
    {
        return $this->calendarReminder() !== null && $this->calendarReminder()->calendar !== null;
    }

    public function hasCalendarButNoAccess(): bool
    {
        return $this->calendarReminder() !== null && $this->calendarReminder()->calendar === null;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        $reminder = $this->calendarReminder();
        $months = $reminder->calendar->months();
        $count = 0;
        $monthCount = 1;
        foreach ($months as $month) {
            $monthType = Arr::get($month, 'type');
            if ($monthType === 'standard') {
                $count++;
            }
            if ($monthCount == $reminder->month) {
                if ($monthType === 'intercalary') {
                    return $reminder->year . '-' . $month["name"] . '-' . $reminder->day;
                }
                return $reminder->year . '-' . $count . '-' . $reminder->day;
            }
            $monthCount++;
        }
        return $reminder->year . '-' . $reminder->month . '-' . $reminder->day;
    }

    /**
     * @return null|int
     */
    public function getCalendarIdAttribute(): int|null
    {
        if (!$this->calendarReminder()) {
            return null;
        }
        return $this->calendarReminder()->calendar_id;
    }

    /**
     * @return null|int
     */
    public function getCalendarYearAttribute(): int|null
    {
        if (!$this->calendarReminder()) {
            return null;
        }
        return $this->calendarReminder()->year;
    }

    /**
     * @return null|int
     */
    public function getCalendarMonthAttribute(): int|null
    {
        if (!$this->calendarReminder()) {
            return null;
        }
        return $this->calendarReminder()->month;
    }

    /**
     * @return null|int
     */
    public function getCalendarDayAttribute(): int|null
    {
        if (!$this->calendarReminder()) {
            return null;
        }
        return $this->calendarReminder()->day;
    }

    /**
     * @return null|int
     */
    public function getCalendarLengthAttribute(): int|null
    {
        if (!$this->calendarReminder()) {
            return null;
        }
        return (int) $this->calendarReminder()->length;
    }

    /**
     * @return bool
     */
    public function getCalendarIsRecurringAttribute(): bool
    {
        return $this->calendarReminder() ? $this->calendarReminder()->is_recurring : false;
    }

    /**
     * recurring_periodicity
     * @return string|null
     */
    public function getCalendarRecurringPeriodicityAttribute(): string|null
    {
        if (!$this->calendarReminder()) {
            return null;
        }
        return $this->calendarReminder()->recurring_periodicity;
    }

    /**
     * Calendar Colour
     * @return null|string
     */
    public function getCalendarColourAttribute()
    {
        if (!$this->calendarReminder()) {
            return '#cccccc';
        }
        return $this->calendarReminder()->colour;
    }

    /**
     * Refactor July 2022
     * Get the reminder associated to the entity's "calendar date"
     */
    public function calendarReminder(): null|EntityEvent
    {
        if ($this->calendarDateEvent !== false) {
            return $this->calendarDateEvent;
        }
        if (!$this->entity) {
            return $this->calendarDateEvent = null;
        }
        $this->calendarDateEvent = $this->entity->calendarDateEvents->first();
        if (!$this->calendarDateEvent || !$this->calendarDateEvent->calendar) {
            return $this->calendarDateEvent = null;
        }

        return $this->calendarDateEvent;
    }
}
