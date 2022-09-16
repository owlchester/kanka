<?php

namespace App\Traits;

use App\Models\Calendar;
use App\Models\EntityEvent;
use App\Models\EntityEventType;
use App\Models\MiscModel;
use Illuminate\Support\Arr;

/**
 * Trait CalendarDateTrait
 * @package App\Traits
 *
 * @property EntityEvent $calendarReminder
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
//        static::saving(function (MiscModel $model) {
//            $model->fillCalendarFieldsOnSave();
//        });

        static::saved(function (MiscModel $model) {
            $this->syncEntityEventOnSaved();
        });
    }

    /**
     * @return bool
     */
    public function hasCalendar(): bool
    {
        return !empty($this->calendarReminder()) && $this->calendarReminder()->calendar;
    }

    public function hasCalendarButNoAccess(): bool
    {
        return !empty($this->calendarReminder()) && empty($this->calendarReminder()->calendar);
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
        return $this->calendarReminder() ? $this->calendarReminder()->calendar_id : null;
    }

    /**
     * @return null|int
     */
    public function getCalendarYearAttribute(): int|null
    {
        return $this->calendarReminder() ? $this->calendarReminder()->year : null;
    }

    /**
     * @return null|int
     */
    public function getCalendarMonthAttribute(): int|null
    {
        return $this->calendarReminder() ? $this->calendarReminder()->month : null;
    }

    /**
     * @return null|int
     */
    public function getCalendarDayAttribute(): int|null
    {
        return $this->calendarReminder() ? $this->calendarReminder()->day : null;
    }

    /**
     * @return null|int
     */
    public function getCalendarLengthAttribute(): int|null
    {
        return $this->calendarReminder() ? $this->calendarReminder()->length : null;
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
        return $this->calendarReminder() ? $this->calendarReminder()->recurring_periodicity : null;
    }

    /**
     * recurring_periodicity
     * @return null|string
     */
    public function getCalendarColourAttribute()
    {
        return $this->calendarReminder() ? $this->calendarReminder()->colour : '#cccccc';
    }

    /**
     * Sync the entity event if the model has the calendar date trait
     * @param void
     */
    protected function syncEntityEventOnSaved(): void
    {
        // If we don't have an entity, not exactly sure what's going on. Skip the entity event
        // observer and let the user report it instead of throwing an ugly error at them.
        if (empty($this->entity)) {
            return;
        }

        // The user is editing an entity with a calendar, but doesn't have the permission to see
        // the calendar? We skip any work.
        if (request()->has('calendar_skip')) {
            return;
        }

        $entity = $this->entity;
        $previousCalendarId = $this->getOriginal('calendar_id');

        // Previously, this lookup was only triggered when the calendar_id or date was dirty. However this excludes just
        // changing the colour or periodicity. To support the API not overriding the values, we still check to make
        // sure that the calendar_id property is set.
        if (!request()->has('calendar_id')) {
            return;
        }
        $calendarID = request()->post('calendar_id');

        // We already had this event linked
        /** @var EntityEvent $reminder */
        $reminder = $this->calendarReminder();
        if (!empty($reminder)) {
            // We no longer have a calendar attached to this model
            if (empty($calendarID)) {
                $reminder->delete();
                return;
            }
        } else {
            $reminder = new EntityEvent();
            $reminder->entity_id = $entity->id;
        }

        // Validate the calendar
        /** @var Calendar $calendar */
        $calendar = Calendar::find($calendarID);
        if (empty($calendar) || $calendar->missingDetails()) {
            return;
        }

        $length = request()->post('calendar_length', '1');
        $length = max(1, $length);
        $reminder->calendar_id = request()->get('calendar_id');
        $reminder->year = request()->post('calendar_year', '1');
        $reminder->month = request()->post('calendar_month', '1');
        $reminder->day = request()->post('calendar_day', '1');
        $reminder->length = $length;
        $reminder->is_recurring = request()->post('calendar_is_recurring', '0');
        $reminder->recurring_periodicity = request()->post('calendar_recurring_periodicity');
        $reminder->colour = request()->post('calendar_colour', '#cccccc');
        $reminder->type_id = EntityEventType::CALENDAR_DATE;
        try {
            $reminder->save();
        } catch (\Exception $e) {
            // Something went wrong, silence the issue
            throw $e;
        }
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
            return null;
        }
        return $this->calendarDateEvent = $this->entity->calendarDateEvents->first();
    }
}
