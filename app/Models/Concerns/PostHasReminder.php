<?php

namespace App\Models\Concerns;

use App\Models\Reminder;
use App\Observers\Remindable;
use App\Observers\RemindablePost;
use Illuminate\Support\Arr;

/**
 * Trait PostHasReminder
 *
 * @property Reminder $calendarReminder
 * @property Reminder|null $calendarDate
 * @property int|null $calendar_id
 * @property int|null $calendar_year
 * @property int|null $calendar_month
 * @property int|null $calendar_day
 */
trait PostHasReminder
{
    /**
     * On boot of the trait, inject the fillable fields.
     */
    public static function bootPostHasReminder()
    {
        static::observe(app(RemindablePost::class));
    }

    public function hasCalendar(): bool
    {
        return $this->hasCalendarDate() && $this->calendarDate->calendar !== null;
    }

    public function hasCalendarButNoAccess(): bool
    {
        return $this->hasCalendarDate() && $this->calendarDate->calendar === null;
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

        return $this->calendarDate->calendar_id;
    }

    public function getCalendarYearAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->calendarDate->year;
    }

    public function getCalendarMonthAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->calendarDate->month;
    }

    public function getCalendarDayAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->calendarDate->day;
    }

    public function getCalendarLengthAttribute(): ?int
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return (int) $this->calendarDate->length;
    }

    /**
     * recurring_periodicity
     */
    public function getCalendarRecurringPeriodicityAttribute(): ?string
    {
        if (! $this->hasCalendarDate()) {
            return null;
        }

        return $this->calendarDate->recurring_periodicity;
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

        return $this->calendarDate->colour;
    }

    public function calendarReminder(): ?Reminder
    {
        return $this->calendarDate;
    }

    protected function hasCalendarDate(): bool
    {
        return isset($this->calendarDate);
    }
}
