<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Concerns\SortableTrait;
use App\Traits\OrderableTrait;
use App\Traits\VisibilityIDTrait;
use Illuminate\Support\Str;

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
    use OrderableTrait, SortableTrait, VisibilityIDTrait, Blameable;

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
        'type_id',
        'visibility_id',
    ];

    protected $sortable = [
        'entity.name',
        'length',
        'date',
        'is_recurring',
        'visibility_id',
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
     * All events before the current calendar's date
     * @param Builder $query
     * @param Calendar $calendar
     * @return Builder
     */
    public function scopeBefore(Builder $query, Calendar $calendar)
    {
        $year = $calendar->currentDate('year');
        $month = $calendar->currentDate('month');
        $day = $calendar->currentDate('date');

        return $query->where('year', '<', $year)
            ->orWhere(function ($sub) use ($year, $month) {
                $sub->where('year', '=', $year)
                    ->where('month', '<', $month);
            })
            ->orWhere(function ($sub) use ($year, $month, $day) {
                $sub->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->where('day', '<=', $day);
            });
    }

    /**
     * All events today and after today
     * @param Builder $query
     * @param Calendar $calendar
     * @return Builder
     */
    public function scopeAfter(Builder $query, Calendar $calendar)
    {
        $year = $calendar->currentDate('year');
        $month = $calendar->currentDate('month');
        $day = $calendar->currentDate('date');

        return $query->where('year', '>', $year)
            ->orWhere(function ($sub) use ($year, $month) {
                $sub->where('year', '=', $year)
                    ->where('month', '>', $month);
            })
            ->orWhere(function ($sub) use ($year, $month, $day) {
                $sub->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->where('day', '>=', $day);
            });
    }

    /**
     * Sort order for the datagrid page
     * @param Builder $query
     * @param string|null $order
     * @return Builder
     */
    public function scopeCustomSortDate(Builder $query, string $order = null)
    {
        return $query
            ->orderBy('year', $order)
            ->orderBy('month', $order)
            ->orderBy('day', $order);
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
     * Length of the event in a readable format (appends "days")
     * @return string
     */
    public function readableLength(): string
    {
        return trans_choice('calendars.fields.length_days', $this->length, ['count' => $this->length]);
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
        return 'colour-pallet ' . (Str::startsWith($this->colour, '#') ? '' : 'bg-' . $this->colour);
    }

    /**
     * @return string
     */
    public function getLabelBackgroundColour(): string
    {
        if (Str::startsWith($this->colour, '#')) {
            return $this->colour;
        }

        return '';
    }

    /**
     * Generate the Entity Event label for the calendar
     * @return string
     */
    public function getLabel(): string
    {
        $label = '';

        if ($this->is_recurring) {
            $label .= '<i class="fa-solid fa-refresh pull-right margin-l-5" data-toggle="tooltip" title="'
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
     * @param int $year
     * @param int $month
     * @param int $day
     * @return bool
     */
    public function isPastDate(int $year, int $month, int $day): bool
    {
        if ($this->year < $year) {
            return true;
        } elseif ($this->year > $year) {
            return false;
        }

        if ($this->month < $month) {
            return true;
        } elseif ($this->month > $month) {
            return false;
        }

        return $this->day <= $day;
    }

    /**
     * @return mixed|null
     */
    /*public function getRecurringPeriodicityAttribute()
    {
        if (!$this->is_recurring) {
            return null;
        }

        return $this->attributes['recurring_periodicity'];
    }*/

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

    /**
     * Functions for the datagrid2
     * @param string $where
     * @return string
     */
    public function deleteName(): string
    {
        return (string) $this->entity->name;
    }
    public function url(string $where): string
    {
        return 'entities.entity_events.' . $where;
    }
    public function routeParams(): array
    {
        return [$this->entity_id, $this->id];
    }
}
