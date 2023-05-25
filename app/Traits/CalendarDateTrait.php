<?php

namespace App\Traits;

use App\Models\Calendar;
use App\Models\EntityEvent;
use App\Observers\Remindable;
use Illuminate\Support\Arr;

/**
 * Trait CalendarDateTrait
 * @package App\Traits
 *
 * @property EntityEvent $calendarReminder
 * @property EntityEvent|null $calendarDate
 * @property int|null $calendar_id
 * @property int|null $calendar_year
 * @property int|null $calendar_month
 * @property int|null $calendar_day
 */
trait CalendarDateTrait
{
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
        dump($this->entity->calendarDate);
        return $this->entity->calendarDate && $this->calendarDate->calendar !== null;
    }

    public function hasCalendarButNoAccess(): bool
    {
        return $this->calendarDate && $this->calendarDate->calendar === null;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        $reminder = $this->calendarDate;
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
        if (!$this->calendarDate) {
            return null;
        }
        return $this->calendarDate->calendar_id;
    }

    /**
     * @return null|int
     */
    public function getCalendarYearAttribute(): int|null
    {
        if (!$this->calendarDate) {
            return null;
        }
        return $this->calendarDate->year;
    }

    /**
     * @return null|int
     */
    public function getCalendarMonthAttribute(): int|null
    {
        if (!$this->calendarDate) {
            return null;
        }
        return $this->calendarDate->month;
    }

    /**
     * @return null|int
     */
    public function getCalendarDayAttribute(): int|null
    {
        if (!$this->calendarDate) {
            return null;
        }
        return $this->calendarDate->day;
    }

    /**
     * @return null|int
     */
    public function getCalendarLengthAttribute(): int|null
    {
        if (!$this->calendarDate) {
            return null;
        }
        return (int) $this->calendarDate->length;
    }

    /**
     * @return bool
     */
    public function getCalendarIsRecurringAttribute(): bool
    {
        return $this->calendarDate ? $this->calendarDate->is_recurring : false;
    }

    /**
     * recurring_periodicity
     * @return string|null
     */
    public function getCalendarRecurringPeriodicityAttribute(): string|null
    {
        if (!$this->calendarDate) {
            return null;
        }
        return $this->calendarDate->recurring_periodicity;
    }

    /**
     * Calendar Colour
     * @return null|string
     */
    public function getCalendarColourAttribute()
    {
        if (!$this->calendarDate) {
            return '#cccccc';
        }
        return $this->calendarDate->colour;
    }
}
