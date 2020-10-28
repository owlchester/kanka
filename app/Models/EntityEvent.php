<?php

namespace App\Models;

use App\Models\Concerns\SimpleSortableTrait;
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
 * @property integer $recurring_periodicity
 * @property integer $type_id
 * @property integer $elapsed
 * @property boolean $is_private
 *
 * @property Calendar $calendar
 * @property EntityEventType $type
 */
class EntityEvent extends MiscModel
{
    /**
     * Traits
     */
    //use VisibleTrait;
    use OrderableTrait, SimpleSortableTrait;

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
     * @var bool tell the AclTrait that this entity has no is_private field
     */
    public $aclIsPrivate = false;

    /**
     * If the ACL engine should use the "real" entity id (entities.id) or the
     * @var bool
     */
    public $aclUseEntityID = true;

    /**
     * @var string Cached readable date
     */
    protected $readableDate;


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
        'recurring_periodicity',
        'colour',
        'day',
        'month',
        'year',
        'type_id'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\Models\EntityEventType', 'type_id');
    }

    /**
     * @return string
     */
    public function readableDate(): string
    {
        if ($this->readableDate === null) {
            // Replace month with real month, and year maybe
            $months = $this->calendar->months();
            $years = $this->calendar->years();

            try {
                $this->readableDate = $this->day . ' ' .
                    (isset($months[$this->month - 1]) ? $months[$this->month - 1]['name'] : $this->month) . ', ' .
                    (isset($years[$this->year]) ? $years[$this->year] : $this->year) . ' ' .
                    $this->calendar->suffix;
            } catch (\Exception $e) {
                $this->readableDate = $this->date();
            }
        }
        return $this->readableDate;
    }

    /**
     * @param Calendar $calendar
     * @return bool
     */
    public function isToday(Calendar $calendar): bool
    {
        return $this->date() === $calendar->date;
    }

    /**
     * @return string
     */
    public function date(): string
    {
        return $this->year . '-' . $this->month . '-' . $this->day;
    }

    /**
     * @return string
     */
    public function getLabelColour(): string
    {
        if (empty($this->colour) || in_array($this->colour, ['default', 'grey'])) {
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

    /**
     * Calculate the elapsed time since the event happened
     */
    public function calcElasped(EntityEvent $event = null)
    {
        if (!empty($event)) {
            $year = $event->year;
            $month = $event->month;
            $day = $event->day;
        } else {
            $year = $this->calendar->currentDate('year');
            $month = $this->calendar->currentDate('month');
            $day = (int) $this->calendar->currentDate('date');
        }

        $years = $year - $this->year;
        if ($month < $this->month) {
            return $years-1;
        }
        if ($month > $this->month) {
            return $years;
        }

        // Same month
        return $years - ($day < $this->day ? 1 : 0);
    }
}
