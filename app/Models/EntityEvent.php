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
 * @property string $recurring_periodicity
 * @property integer $type_id
 * @property integer $elapsed
 * @property boolean $is_private
 *
 * @property Calendar $calendar
 * @property EntityEventType $type
 */
class EntityEvent extends MiscModel
{
    /** Traits */
    use OrderableTrait, SortableTrait, VisibilityIDTrait, Blameable;

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'events/';
    protected $orderDefaultDir = 'desc';

    /** @var string */
    public $table = 'entity_events';

    /** @var string Cached readable date */
    protected $readableDate;

    /** @var array */
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

    /** @var bool|int Last occurence of the reminder */
    protected $cachedLast = false;

    /** @var bool|int Next occurence of the reminder */
    protected $cachedNext = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(EntityEventType::class, 'type_id');
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

    public function scopeEntity(Builder $query, int $entity_id)
    {
        return $query->where('entity_id', $entity_id);
    }

    public function scopeCalendar(Builder $query, int $calendar_id)
    {
        return $query->where('calendar_id', $calendar_id);
    }

    public function scopeCalendarDate(Builder $query)
    {
        return $query->where('type_id', EntityEventType::CALENDAR_DATE);
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
            $label .= '<i class="fa-solid fa-arrows-rotate pull-right margin-l-5" data-toggle="tooltip" title="'
                . __('calendars.fields.is_recurring') . '"></i>';
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
     * @return int years
     */
    public function calcElapsed(EntityEvent $event = null): int
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
            return $years - 1;
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
    public function routeParams(array $options = []): array
    {
        return [$this->entity_id, $this->id];
    }

    /**
     * Calculate how long ago the event happened
     * @param int $year
     * @param int $month
     * @param int $day
     * @param array $months
     * @param int $daysInYear
     * @return int
     */
    public function mostRecentOccurrence(int $year, int $month, int $day, array $months, int $daysInYear): int
    {
        //dump($this->entity->name);
        $reminderYear = $this->year;
        $reminderMonth = $this->month;
        $reminderDay = $this->day;

        // Recurring? We need to switch around the data a bit to figure out the most recent date
        if (!empty($this->is_recurring)) {
            if ($this->recurringMonthly()) {
                //dump('monthly');
                $reminderMonth = $month;
                $reminderYear = $year;
                // If it repeats monthly, we need to see if it happened "last month" or "this month".
                //dump('Reminder ' . $reminderDay . ' > ' . $day);
                if ($reminderDay > $day) {
                    $reminderMonth--;
                    // Switched to previous month?
                    if ($reminderMonth === 0) {
                        $reminderMonth = $month;
                        $reminderYear--;
                    }
                }
            } else {
                // Yearly is easy
                //dump('yearly recurring');
                $reminderYear = $year;
                $reminderMonth = $month;
            }
        }
        // Diff in years between current year and reminder's year
        $days = ($year - $reminderYear) * $daysInYear;
        // Not the same month? We need to do some math
        if ($month != $reminderMonth) {
            //dump('month diff ' . $month . ' (current) vs ' . $reminderMonth . '(reminder)');
            //dump('amount of months ' . count($months));
            $totalMounts = count($months);

            // If the reminder a month in the future, meaning it was another year
            if ($reminderMonth > $month) {
                //dump('last year');
                $days -= $daysInYear;

                // Loop through the beginning of the year
                for ($m = 1; $m < $month; $m++) {
                    //dump('beginning of the year');
                    // Month status
                    $monthData = $months[$m - 1];
                    $days += $monthData['length'];
                }
                for ($m = $reminderMonth; $m <= $totalMounts; $m++) {
                    //dump('end of previous year');
                    $monthData = $months[$m - 1];
                    $days += $monthData['length'];
                    //dump('days increase by ' . $monthData['length']);
                }
            } else {
                // The event happened earlier this year
                for ($m = $reminderMonth; $m < $month; $m++) {
                    //dump('previous month');
                    $monthData = $months[$m - 1];
                    $days += $monthData['length'];
                }
            }
        }

        // Diff in days
        $days += ($day - $reminderDay);

        if ($days > 1 && $this->length > 1) {
            $days -= $this->length - 1;
        }

        //dump($days);
        return $this->cachedLast = $days;
    }

    /**
     * Calculate when this reminder happens next. We want the YYYYYYYMMMMDDDD format, and use that as a string to
     * order by, instead of doing complicated math. Or do we? I don't know, I'm so confused. This is all super
     * hard to calculate :(
     * @param int $calendarYear
     * @param int $calendarMonth
     * @param int $day
     * @param array $months
     * @param int $daysInYear
     * @return int
     */
    public function nextUpcomingOccurrence(int $calendarYear, int $calendarMonth, int $day, array $months, int $daysInYear): int
    {
        if ($this->cachedNext !== false) {
            return $this->cachedNext;
        }
        //dump($this->entity->name);
        $reminderYear = $this->year;
        $reminderMonth = $this->month;
        $reminderDay = $this->day;

        //dump("Event #" . $this->id . " " . $this->entity->name . ": " . $this->year . "-" . $this->month . "-" . $this->day);

        // Recurring? We need to switch around the data a bit to figure out the most recent date
        if (!empty($this->is_recurring)) {
            if ($this->recurringMonthly()) {
                $reminderMonth = $calendarMonth;
                // Max to properly track reminders starting in the future
                $reminderYear = max($reminderYear, $calendarYear);
                // If it repeats monthly, we need to see if it happened "last month" or "this month".
                //dump('Reminder ' . $reminderDay . ' > ' . $day);
                if ($reminderDay < $day) {
                    $reminderMonth++;
                    // Switched to previous month?
                    if ($reminderMonth === count($months) - 1) {
                        $reminderMonth = $calendarMonth;
                        $reminderYear++;
                    }
                }
            } else {
                // It's a yearly reoccurring event, so we need to put the reminder's date to the "next" available one
                // in the future.
                $reminderYear = $calendarYear; // Make sure it's the same year
                // If the month is earlier from this year, we need to push the next occurrence to next year. The month
                // stays the same
                if ($reminderMonth === $calendarMonth && $reminderDay < $day) {
                    $reminderYear++;
                }
            }
        }

        $days = 0;
        // We loop on every extra year, ex 2000 to 2004
        for ($y = $calendarYear; $y < $reminderYear; $y++) {
            $days += $daysInYear;
            //dump("Add a year");
        }

        // If the reminder happens "before" the same month / same date, we need to reduce the days by one year
        // current: 2004-05-01 and reminder is 2005-03-15
        if ($days > 0 && ($reminderMonth < $calendarMonth)) {
            $days -= $daysInYear;
            //dump("Remove a year");
        }

        // Now we need to loop on the remaining months.
        $monthStart = $calendarMonth; // ex August
        $monthEnd = $reminderMonth; // ex September
        //dump("Comparing $reminderMonth < $calendarMonth");
        if ($reminderMonth < $calendarMonth) {
            // The reminder's month is before the current calendar month, so we jumped a year.
            // ex reminder is in April and calendar is currently in August
            $monthStart = 1;
            $totalMonths = count($months);
            // We still need to add days to the end of the current year before switching to the next one
            //dump("Backfilling $calendarMonth to $totalMonths");
            for ($m = $calendarMonth; $m <= $totalMonths; $m++) {
                $monthData = $months[$m - 1];
                $days += $monthData['length'];
            }
            //$monthEnd = $reminderMonth;
        }
        //dump("Month start $monthStart and $monthEnd");
        for ($m = $monthStart; $m < $monthEnd; $m++) {
            $monthData = $months[$m - 1];
            $days += $monthData['length'];
        }

        $days += ($reminderDay - $day);
        return $this->cachedNext = $days;

        // OLD CODE

        // If the next occurrence is later this year, we just loop on the months
        $days = 0;
        if ($reminderYear === $calendarYear) {
            for ($m = $reminderMonth; $m <= $calendarMonth; $m++) {
                $monthData = $months[$m - 1];
                $days += $monthData['length'];
            }
        } else {
            // It's in the future,
            for ($y = $calendarYear; $y < $reminderYear; $y++) {
                $days += $daysInYear;
            }
        }
        // Not the same month? We need to do some math
        dump('Not the same month?' . $calendarMonth . ' != ' . $reminderMonth);
        dump("Next reminder set to happen in " . $reminderYear . '-' . $reminderMonth . '-' . $reminderDay);
        if ($calendarMonth != $reminderMonth) {
            //dump('month diff ' . $month . ' (current) vs ' . $reminderMonth . '(reminder)');
            //dump('amount of months ' . count($months));
            $totalMonths = count($months);

            // If the reminder was last year, cancel out one year
            //if (!empty($this->is_recurring) && $reminderMonth > $month) {
            //    $days -= $daysInYear;
            //}

            // Loop through the beginning of the year
            /*for ($m = 1; $m < $calendarMonth; $m++) {
                //dump('beginning of the year');
                // Month status
                $monthData = $months[$m - 1];
                $days += $monthData['length'];
            }*/
            // If the month is in the future, add for the rest of the year
            dump($reminderMonth . ' vs ' . $totalMonths);
            for ($m = $reminderMonth; $m <= $calendarMonth; $m++) {
                //dump('end of previous year');
                $monthData = $months[$m - 1];
                $days += $monthData['length'];
                dump('days increase by ' . $monthData['length']);
            }
        }

        // Diff in days
        $days += ($reminderDay - $day);

        return $this->cachedNext = $days;
    }

    /**
     * Determine if a reminder is recurring every year
     * @return bool
     */
    public function recurringYearly(): bool
    {
        return $this->is_recurring && $this->recurring_periodicity === 'year';
    }

    /**
     * Determine if a reminder is recurring every month
     * @return bool
     */
    public function recurringMonthly(): bool
    {
        return $this->is_recurring && $this->recurring_periodicity === 'month';
    }

    /**
     * How many days ago the last occurrence was
     * @return int
     */
    public function daysAgo(): int
    {
        return $this->cachedLast;
    }

    /**
     * In how many days the next reminder is
     * @return int
     */
    public function inDays(): int
    {
        return $this->cachedNext;
    }

    /**
     * Determine if an event is of the character birth type
     * @return bool
     */
    public function isBirth(): bool
    {
        return $this->type_id === EntityEventType::BIRTH;
    }

    /**
     * Determine if an event is of the entity foundation type
     * @return bool
     */
    public function isFounded(): bool
    {
        return $this->type_id === EntityEventType::FOUNDED;
    }

    /**
     * Determine if an event is of the character death type
     * @return bool
     */
    public function isDeath(): bool
    {
        return $this->type_id === EntityEventType::DEATH;
    }

    /**
     * Determine if an event is of the calendar date type
     * @return bool
     */
    public function isCalendarDate(): bool
    {
        return $this->type_id === EntityEventType::CALENDAR_DATE;
    }
}
