<?php

namespace App\Traits;

/**
 * Trait CalendarDateTrait
 * @package App\Traits
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
}
