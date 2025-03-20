<?php

namespace App\Traits;

use App\Models\Calendar;
use App\Models\EntityEvent;
use App\Observers\Remindable;
use Illuminate\Support\Arr;

/**
 * Trait CalendarDateTrait
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

    public function hasCalendar(): bool
    {
        return $this->hasCalendarDate() && $this->entity->calendarDate->calendar !== null;
    }

    public function hasCalendarButNoAccess(): bool
    {
        return $this->hasCalendarDate() && $this->entity->calendarDate->calendar === null;
    }

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
                    return $reminder->year . '-' . $month['name'] . '-' . $reminder->day;
                }

                return $reminder->year . '-' . $count . '-' . $reminder->day;
            }
            $monthCount++;
        }

        return $reminder->year . '-' . $reminder->month . '-' . $reminder->day;
    }

    public function getCalendarIdAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->entity->calendarDate->calendar_id;
    }

    public function getCalendarYearAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->entity->calendarDate->year;
    }

    public function getCalendarMonthAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->entity->calendarDate->month;
    }

    public function getCalendarDayAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->entity->calendarDate->day;
    }

    public function getCalendarLengthAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return (int) $this->entity->calendarDate->length;
    }

    /**
     * recurring_periodicity
     */
    public function getCalendarRecurringPeriodicityAttribute(): ?string
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->entity->calendarDate->recurring_periodicity;
    }

    /**
     * Calendar Colour
     *
     * @return null|string
     */
    public function getCalendarColourAttribute()
    {
        if (! $this->hasCalendarDate()) {
            return '#cccccc';
        }

        return $this->entity->calendarDate->colour;
    }

    public function calendarReminder(): ?EntityEvent
    {
        return $this->entity?->calendarDate;
    }

    protected function hasCalendarDate(): bool
    {
        return $this->entity && $this->entity->calendarDate;
    }
}
