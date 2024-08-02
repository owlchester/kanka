<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Scopes\EntityEventScopes;
use Exception;
use App\Models\Concerns\SortableTrait;
use App\Traits\HasVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EntityEvent
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_id
 * @property int $calendar_id
 * @property string $date
 * @property int $length
 * @property string $comment
 * @property string $colour
 * @property int $day
 * @property int $month
 * @property int $year
 * @property bool|int $is_recurring
 * @property int|null $recurring_until
 * @property string $recurring_periodicity
 * @property int $type_id
 * @property int|null $elapsed
 *
 * @property Calendar|null $calendar
 * @property EntityEvent|null $death
 * @property EntityEventType|null $type
 */
class EntityEvent extends Model
{
    use Blameable;
    use EntityEventScopes;
    use HasFactory;
    use HasVisibility;
    use SortableTrait;

    /** @var string */
    public $table = 'entity_events';

    /** @var string Cached readable date */
    protected string $readableDate;

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

    protected array $sortable = [
        'entity.name',
        'length',
        'date',
        'is_recurring',
        'visibility_id',
        'comment'
    ];

    /** Last occurrence of the reminder */
    protected int $cachedLast;

    /** Next occurrence of the reminder */
    protected int $cachedNext;

    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class, 'calendar_id');
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(EntityEventType::class, 'type_id');
    }

    /**
     */
    public function readableDate(): string
    {
        if (!isset($this->readableDate)) {
            // Replace month with real month, and year maybe
            $months = $this->calendar->months();
            $years = $this->calendar->years();

            try {
                if ($this->calendar->format) {
                    $this->readableDate = Str::replace(
                        ['d', 's', 'y', 'm', 'M'],
                        [$this->day, $this->calendar->suffix, $years[$this->year] ?? $this->year, $this->month, isset($months[$this->month - 1]) ? $months[$this->month - 1]['name'] : $this->month],
                        $this->calendar->format
                    );
                } else {
                    $this->readableDate = $this->day . ' ' .
                        (isset($months[$this->month - 1]) ? $months[$this->month - 1]['name'] : $this->month) . ', ' .
                        ($years[$this->year] ?? $this->year) . ' ' .
                        $this->calendar->suffix;
                }
            } catch (Exception $e) {
                $this->readableDate = $this->date();
            }
        }
        return $this->readableDate;
    }

    /**
     * Length of the event in a readable format (appends "days")
     */
    public function readableLength(): string
    {
        return trans_choice('calendars.fields.length_days', $this->length, ['count' => $this->length]);
    }

    /**
     */
    public function isToday(Calendar $calendar): bool
    {
        return $this->date() === $calendar->date;
    }

    /**
     */
    public function date(): string
    {
        return $this->year . '-' . $this->month . '-' . $this->day;
    }

    /**
     */
    public function getLabelColour(): string
    {
        if (empty($this->colour) || in_array($this->colour, ['default', 'grey', '#cccccc'])) {
            return 'colour-pallet bg-gray';
        }
        return 'colour-pallet ' . (Str::startsWith($this->colour, '#') ? '' : 'bg-' . $this->colour);
    }

    /**
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
     */
    public function getLabel(): string
    {
        $label = '';

        if ($this->is_recurring) {
            $label .= '<span class="absolute top-1 right-1" data-toggle="tooltip" data-title="' . __('calendars.fields.is_recurring') . '">
            <i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i>
            </span>';
        }
        if ($this->comment) {
            $label .= '<span class="calendar-event-comment" data-toggle="tooltip" data-title="'
                . e($this->comment) . '">' . e($this->comment) . '</span>';
        }

        return $label;
    }

    /**
     * Check if a reminder is after the current date of a given calendar
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
     * Calculate the elapsed time since the event happened
     * @return int years
     */
    public function calcElapsed(?EntityEvent $event = null): int
    {
        // Have the value cached? Don't bother with more work
        if (empty($event) && !empty($this->elapsed)) {
            return $this->elapsed;
        }

        if (!empty($event)) {
            $year = $event->year;
            $month = $event->month;
            $day = $event->day;
        } else {
            $year = $this->calendar->currentDate('year');
            $month = $this->calendar->currentDate('month');
            $day = (int) $this->calendar->currentDate('date');
        }

        // Current reminder is pre 0, calendar is > 0
        $baseYear = $this->year;
        if ($this->year < 0 && $year > 0 && !$this->calendar->hasYearZero()) {
            $baseYear++;
        }
        $years = $year - $baseYear;

        if ($month < $this->month) {
            return $this->saveElapsed($years - 1, empty($event));
        }
        if ($month > $this->month) {
            return $this->saveElapsed($years, empty($event));
        }

        // Same month
        return $this->saveElapsed($years - ($day < $this->day ? 1 : 0), empty($event));
    }

    protected function saveElapsed(int $number, bool $save): int
    {
        // If comparing two days, don't save the "elapsed" part, we need to re-calc those one each page load
        if (!$save || $number < 0) {
            return $number;
        }
        $this->elapsed = $number;
        $this->saveQuietly();
        return $this->elapsed;
    }

    /**
     * Functions for the datagrid2
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
        return $options + ['entity' => $this->entity_id, 'entity_event' => $this->id, 'next' => 'entity.events'];
    }

    public function getNameAttribute(): string
    {
        return $this->deleteName();
    }

    /**
     * Calculate how long ago the event happened
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

        if (!$this->calendar->hasYearZero() && $year > 0 && $reminderYear < 0) {
            $days = ($year - 1 - $reminderYear) * $daysInYear;
        } else {
            $days = ($year - $reminderYear) * $daysInYear;
        }

        // Not the same month? We need to do some math
        if ($month != $reminderMonth) {
            //dump('month diff ' . $month . ' (current) vs ' . $reminderMonth . '(reminder)');
            //dump('amount of months ' . count($months));
            $totalMonths = count($months);

            // If the reminder a month in the future, meaning it was another year
            if ($reminderMonth > $month) {
                //dump('last year');
                $days -= $daysInYear;

                // Loop through the beginning of the year
                for ($m = 1; $m < $month; $m++) {
                    //dump('beginning of the year');
                    // Month status
                    $previousMonth = $this->previousMonth($m, $totalMonths);
                    $monthData = $months[$previousMonth];
                    $days += $monthData['length'];
                }
                for ($m = $reminderMonth; $m <= $totalMonths; $m++) {
                    //dump('end of previous year');
                    $previousMonth = $this->previousMonth($m, $totalMonths);
                    $monthData = $months[$previousMonth];
                    $days += $monthData['length'];
                    //dump('days increase by ' . $monthData['length']);
                }
            } else {
                // The event happened earlier this year
                for ($m = $reminderMonth; $m < $month; $m++) {
                    //dump('previous month');
                    $previousMonth = $this->previousMonth($m, $totalMonths);
                    $monthData = $months[$previousMonth];
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
     */
    public function nextUpcomingOccurrence(int $calendarYear, int $calendarMonth, int $day, array $months, int $daysInYear): int
    {
        if (isset($this->cachedNext)) {
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
        if (!$this->calendar->hasYearZero() && $calendarYear < 0 && $reminderYear > 0) {
            $days -= $daysInYear;
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
        $totalMonths = count($months);
        //dump("Comparing $reminderMonth < $calendarMonth");
        if ($reminderMonth < $calendarMonth) {
            // The reminder's month is before the current calendar month, so we jumped a year.
            // ex reminder is in April and calendar is currently in August
            $monthStart = 1;
            // We still need to add days to the end of the current year before switching to the next one
            //dump("Backfilling $calendarMonth to $totalMonths");
            for ($m = $calendarMonth; $m <= $totalMonths; $m++) {
                $previousMonth = $this->previousMonth($m, $totalMonths);
                $monthData = $months[$previousMonth];
                $days += $monthData['length'];
            }
            //$monthEnd = $reminderMonth;
        }
        //dump("Month start $monthStart and $monthEnd");
        for ($m = $monthStart; $m < $monthEnd; $m++) {
            $previousMonth = $this->previousMonth($m, $totalMonths);
            $monthData = $months[$previousMonth];
            $days += $monthData['length'];
        }

        $days += ($reminderDay - $day);
        return $this->cachedNext = $days;
    }

    /**
     * Determine if a reminder is recurring every year
     */
    public function recurringYearly(): bool
    {
        return $this->is_recurring && $this->recurring_periodicity === 'year';
    }

    /**
     * Determine if a reminder is recurring every month
     */
    public function recurringMonthly(): bool
    {
        return $this->is_recurring && $this->recurring_periodicity === 'month';
    }

    /**
     * How many days ago the last occurrence was
     */
    public function daysAgo(): int
    {
        return $this->cachedLast;
    }

    /**
     * In how many days the next reminder is
     */
    public function inDays(): int
    {
        return $this->cachedNext;
    }

    /**
     * Determine if an event is of the character birth type
     */
    public function isBirth(): bool
    {
        return $this->type_id === EntityEventType::BIRTH;
    }

    /**
     * Determine if an event is of the entity foundation type
     */
    public function isFounded(): bool
    {
        return $this->type_id === EntityEventType::FOUNDED;
    }

    /**
     * Determine if an event is of the character death type
     */
    public function isDeath(): bool
    {
        return $this->type_id === EntityEventType::DEATH;
    }

    /**
     * Determine if an event is of the calendar date type
     */
    public function isCalendarDate(): bool
    {
        return $this->type_id === EntityEventType::CALENDAR_DATE;
    }

    /**
     * Reduce the month by one, making sure it's still in the bounds of a valid month
     */
    protected function previousMonth(int $month, int $min): int
    {
        if ($month >= $min) {
            return $min - 1;
        }
        return $month--;
    }

    public function death()
    {
        return $this->hasOne(EntityEvent::class, 'entity_id', 'entity_id')->whereColumn('calendar_id', 'entity_events.calendar_id')->where('type_id', EntityEventType::DEATH);
    }

    /**
     * Patch an entity from the datagrid2 batch editing
     */
    public function patch(array $data): bool
    {
        return $this->updateQuietly($data);
    }

    public function exportFields(): array
    {
        return [
            'id',
            'calendar_id',
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
            'created_by',
        ];
    }
}
