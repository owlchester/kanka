<?php

namespace App\Traits;

use App\Models\EntityEvent;
use App\Models\MiscModel;

/**
 * Trait CalendarDateTrait
 * @package App\Traits
 *
 * @var integer $calendar_year
 * @var integer $calendar_month
 * @var integer $calendar_day
 * @var integer $calendar_id
 */
trait CalendarDateTrait
{
    /**
     * @var bool
     */
    public $calendarDate = true;


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
        return !empty($this->calendar_id);
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->calendar_year . '-' . $this->calendar_month . '-' . $this->calendar_day;
    }

    /**
     *
     */
//    protected function fillCalendarFieldsOnSave()
//    {
//    }
    
    /**
     * Sync the entity event if the model has the calendar date trait
     * @param $model
     */
    protected function syncEntityEventOnSaved()
    {
        $entity = $this->entity;
        $previousCalendarId = $this->getOriginal('calendar_id');
        $previousDate = $this->getOriginal('calendar_year') . '-'
            . $this->getOriginal('calendar_month') . '-'
            . $this->getOriginal('calendar_day');

        // If the calendar data changed, we need to update a related entity.
        if ($this->isDirty(['calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'])) {
            // We already had this event linked
            $event = EntityEvent::where([
                'calendar_id' => $previousCalendarId,
                'entity_id' => $entity->id,
                'date' => $previousDate
            ])->first();
            if ($event) {
                // We no longer have a calendar attached to this model
                if (empty($this->calendar_id)) {
                    $event->delete();
                } else {
                    // Update the existing one
                    $event->calendar_id = $this->calendar_id;
                    $event->date = $this->calendar_year . '-'
                        . $this->calendar_month . '-'
                        . $this->calendar_day;
                    $event->save();
                }
            } elseif ($this->hasCalendar()) {
                // We need to create something
                EntityEvent::create([
                    'calendar_id' => $this->calendar_id,
                    'entity_id' => $entity->id,
                    'date' => $this->calendar_year . '-'
                        . $this->calendar_month . '-'
                        . $this->calendar_day,
                    'length' => request()->post('length', 1),
                    'is_recurring' => request()->post('is_recurring', false),
                ]);
            }
        }
    }
}
