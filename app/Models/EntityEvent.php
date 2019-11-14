<?php

namespace App\Models;

use App\Traits\OrderableTrait;

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
 * @property integer $day
 * @property integer $month
 * @property integer $year
 * @property boolean $is_recurring
 * @property integer $recurring_until
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
    protected $orderDefaultDir = 'desc';

    /**
     * @var string
     */
    public $table = 'entity_events';

    /**
     * Key used for the scopeAcl trait
     * @var string
     */
    public $aclFieldName = 'entity_events.entity_id';

    /**
     * If the ACL engine should use the "real" entity id (entities.id) or the
     * @var bool
     */
    public $aclUseEntityID = true;


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
        'day',
        'month',
        'year'
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
        // Replace month with real month, and year maybe
        $months = $this->calendar->months();
        $years = $this->calendar->years();

        try {
            return $this->day . ' ' .
                (isset($months[$this->month - 1]) ? $months[$this->month - 1]['name'] : $this->month) . ', ' .
                (isset($years[$this->year]) ? $years[$this->year] : $this->year) . ' ' .
                $this->calendar->suffix;
        } catch (\Exception $e) {
            return $this->date;
        }
    }

    /**
     * @return string
     */
    public function getLabelColour(): string
    {
        if (empty($this->colour) || $this->colour == 'default') {
            return 'colour-pallet bg-gray';
        }
        return 'colour-pallet bg-' . $this->colour;
    }

    /**
     * Generate the Entity Event label for the calendar
     * @return string
     */
    public function getLabel(): string
    {
        $label = '';

        if ($this->is_recurring) {
            $label .= '<i class="fa fa-refresh pull-right margin-l-5" data-toggle="tooltip" title="'
                . trans('calendars.fields.is_recurring') . '"></i>';
        }
        if ($this->comment) {
            $label .= '<span class="calendar-event-comment" data-toggle="tooltip" title="'
                . e($this->comment) . '">' . e($this->comment) . '</span>';
        }

        return $label;
    }

    /**
     * Check if a reminder is after the current date of a given calendar
     * @param Calendar $calendar
     * @return bool
     */
    public function isPast(Calendar $calendar): bool
    {
        // First check the year
        if ($this->year < $calendar->currentDate('year')) {
            return true;
        } elseif ($this->year > $calendar->currentDate('year')) {
            return false;
        }

        // Current year is reminder's year, check month
        if ($this->month < $calendar->currentDate('month')) {
            return true;
        } elseif ($this->month > $calendar->currentDate('month')) {
            return false;
        }

        // Current month, check on day
        return $this->day < $calendar->currentDate('date');
    }
}
