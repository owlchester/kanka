<?php

namespace App\Traits;

use App\Models\EntityEvent;
use App\Models\MiscModel;

/**
 * Trait CalendarDateTrait
 * @package App\Traits
 *
 * @property integer $calendar_year
 * @property integer $calendar_month
 * @property integer $calendar_day
 * @property integer $calendar_id
 */
trait CalendarDateTrait
{
    /**
     * @var bool
     */
    public $calendarDate = true;

    protected $cachedCalendarEntityEvent = false;


    /**
     * On boot of the trait, inject the fillable fields.
     */
    public static function bootCalendarDateTrait()
    {
//        static::saving(function (MiscModel $model) {
//            $model->fillCalendarFieldsOnSave();
//        });

        static::saved(function (MiscModel $model) {
            $model->syncEntityEventOnSaved();
        });
    }

    /**
     * @return mixed
     */
    public function calendar()
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id');
    }

    /**
     * Used to know a model is using this trait
     * @return bool
     */
    public function hasCalendarDateTrait()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function hasCalendar()
    {
        return !empty($this->calendar_id) && $this->calendar;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->calendar_year . '-' . $this->calendar_month . '-' . $this->calendar_day;
    }

    /**
     * @return |null
     */
    public function getLengthAttribute()
    {
        return $this->calendarEntityEvent() ? $this->calendarEntityEvent()->length : null;
    }

    /**
     * @return |null
     */
    public function getIsRecurringAttribute()
    {
        return $this->calendarEntityEvent() ? $this->calendarEntityEvent()->is_recurring : 0;
    }

    /**
     * recurring_periodicity
     * @return |null
     */
    public function getRecurringPeriodicityAttribute()
    {
        return $this->calendarEntityEvent() ? $this->calendarEntityEvent()->recurring_periodicity : '';
    }

    /**
     * recurring_periodicity
     * @return |null
     */
    public function getCalendarColourAttribute()
    {
        return $this->calendarEntityEvent() ? $this->calendarEntityEvent()->colour : 'grey';
    }

    /**
     * Get the synced event. Or at least try
     * @return EntityEvent|\Illuminate\Database\Eloquent\Model|object|null
     */
    protected function calendarEntityEvent()
    {
        if ($this->cachedCalendarEntityEvent === false) {
            $this->cachedCalendarEntityEvent = null;
            if ($this->hasCalendar()) {
                $this->cachedCalendarEntityEvent = EntityEvent::where([
                    'entity_id' => $this->entity->id,
                    'calendar_id' => $this->calendar->id,
                    'year' => $this->calendar_year,
                    'month' => $this->calendar_month,
                    'day' => $this->calendar_day,
                ])->first();
            }
        }

        return $this->cachedCalendarEntityEvent;
    }

    /**
     * Sync the entity event if the model has the calendar date trait
     * @param $model
     */
    protected function syncEntityEventOnSaved()
    {
        $entity = $this->entity;
        $previousCalendarId = $this->getOriginal('calendar_id');

        // Previously, this lookup was only triggered when the calendar_id or date was dirty. However this excludes just
        // changing the colour or periodicity. To support the API not overriding the values, we still check to make
        // sure that the calendar_id property is set.
        if (!request()->has('calendar_id')) {
            return;
        }

        // We already had this event linked
        /** @var EntityEvent $event */
        $event = EntityEvent::where([
            'calendar_id' => $previousCalendarId,
            'entity_id' => $entity->id,
            'year' => $this->getOriginal('calendar_year'),
            'month' => $this->getOriginal('calendar_month'),
            'day' => $this->getOriginal('calendar_day'),
        ])->first();
        if ($event) {
            // We no longer have a calendar attached to this model
            if (empty($this->calendar_id)) {
                $event->delete();
                unset($event);
            }
        } elseif ($this->hasCalendar()) {
            $event = new EntityEvent();
            $event->entity_id = $entity->id;
        }

        if (isset($event) && $event) {
            $event->calendar_id = $this->calendar_id;
            $event->year = $this->calendar_year;
            $event->month = $this->calendar_month;
            $event->day = $this->calendar_day;
            $event->length = request()->post('length', 1);
            $event->is_recurring = request()->post('is_recurring', false);
            $event->recurring_periodicity = request()->post('recurring_periodicity', null);
            $event->colour = request()->post('calendar_colour', null);
            $event->save();
        }
    }
}
