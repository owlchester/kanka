<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\OrderableTrait;
use App\Traits\VisibleTrait;

/**
 * Class EntityEvent
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $calendar_id
 * @property string $date
 * @property integer $length
 * @property string $comment
 * @property string $colour
 * @property boolean $is_recurring
 * @property boolean $is_private
 */
class EntityEvent extends MiscModel
{
    /**
     * Traits
     */
    //use VisibleTrait;
    use OrderableTrait;

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'events/';

    /**
     * @var string
     */
    public $table = 'entity_events';

    /**
     * @var array
     */
    protected $fillable = [
        'calendar_id',
        'entity_id',
        'date',
        'length',
        'comment',
        'is_recurring',
        'recurring_until',
        'colour',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    /**
     * @return string
     */
    public function getDate()
    {
        $date = explode('-', $this->date);

        // Replace month with real month, and year maybe
        $months = $this->calendar->months();
        $years = $this->calendar->years();

        try {
            return $date[2] . ' ' .
                (isset($months[$date[1] - 1]) ? $months[$date[1] - 1]['name'] : $date[1]) . ', ' .
                (isset($years[$date[0]]) ? $years[$date[0]] : $date[0]) . ' ' .
                $this->calendar->suffix;
        } catch(\Exception $e) {
            return $this->date;
        }
    }

    /**
     * @return string
     */
    public function getLabelColour()
    {
        if (empty($this->colour)) {
            return 'label-default';
        }
        return 'colour-pallet bg-' . $this->colour;
    }

    /**
     * Generate the Entity Event label for the calendar
     * @return string
     */
    public function getLabel()
    {
        $label = '';

        if ($this->is_recurring) {
            $label .= '<i class="fa fa-refresh pull-right margin-l-5" data-toggle="tooltip" title="' . trans('calendars.fields.is_recurring') . '"></i>';
        }
        if ($this->comment) {
            $label .= '<span class="calendar-event-comment" data-toggle="tooltip" title="' . e($this->comment) . '">' . e($this->comment) . '</span>';
        }

        return $label;
    }

    /**
     * @return mixed
     */
    public function getYearAttribute()
    {
        $segments = explode('-', $this->date);
        return array_get($segments, 0, 1);
    }

    /**
     * @return mixed
     */
    public function getMonthAttribute()
    {
        $segments = explode('-', $this->date);
        return array_get($segments, 1, 1);
    }

    /**
     * @return mixed
     */
    public function getDayAttribute()
    {
        $segments = explode('-', $this->date);
        return array_get($segments, 2, 1);
    }

    /**
     * @param $date
     */
    public function setDate($date)
    {
        $this->date = $date['year'] . '-' . $date['month'] . '-' . $date['day'];
    }
}
