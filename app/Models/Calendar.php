<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Relations\CalendarRelations;
use App\Traits\ExportableTrait;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Calendar
 * @package App\Models
 *
 * @property string $date
 * @property int $start_offset
 * @property string $months
 * @property string $years
 * @property string $weekdays
 * @property string $week_names
 * @property string $month_aliases
 * @property string $seasons
 * @property string $moons
 * @property string $reset
 * @property string $format
 * @property string $suffix
 * @property int $calendar_id
 * @property array $parameters
 * @property bool|int $skip_year_zero
 * @property bool|int $show_birthdays
 */
class Calendar extends MiscModel
{
    use Acl;
    use CalendarRelations;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'name',
        'start_offset',
        'is_private',
        'parameters',
        'months',
        'weekdays',
        'years',
        'seasons',
        'moons',
        'date',
        'suffix',
        'skip_year_zero',
        'epochs',
        'month_aliases',
        'week_names',
        'reset',
        'is_incrementing',
        'format',
        'show_birthdays',

        // Leap year
        'has_leap_year',
        'leap_year_amount', // Add X number of days
        'leap_year_month', // At the end of month X
        'leap_year_offset', // every X years
        'leap_year_start', // X year is a leap year

        'calendar_id',
    ];

    /** @var array<string, string> */
    public $casts = [
        'parameters' => 'array'
    ];

    protected array $foreignExport = [
        'calendarWeather',
    ];

    protected array $loadedMonths;

    protected array $loadedWeekdays;

    protected array $loadedYears;

    protected array $loadedSeasons;

    protected array $loadedMoons;

    protected array $loadedWeeks;

    protected array $loadedMonthAliases;

    protected string $entityType = 'calendar';

    protected array $cachedCurrentDate;

    /**
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['calendar_id', 'date'];
    }

    public function getParentKeyName(): string
    {
        return 'calendar_id';
    }

    /**
     * Get the months decoded from the json into a usable array
     */
    public function months(): array
    {
        if (isset($this->loadedMonths)) {
            return $this->loadedMonths;
        }
        return (array) $this->loadedMonths = !empty($this->months) ?
            json_decode(strip_tags($this->months), true) : [];
    }

    /**
     * Get the weekdays
     */
    public function weekdays(): array
    {
        if (!isset($this->loadedWeekdays)) {
            $this->loadedWeekdays = [];
            if (!empty($this->months)) {
                $this->loadedWeekdays = json_decode(strip_tags($this->weekdays), true);
            }
        }
        return $this->loadedWeekdays;
    }

    /**
     * Get the weekdays
     */
    public function years(): array
    {
        if (!isset($this->loadedYears)) {
            $this->loadedYears = [];
            if (!empty($this->years)) {
                $this->loadedYears = json_decode(strip_tags($this->years), true);
            }
        }
        return $this->loadedYears;
    }

    /**
     * Get the calendar's moons
     */
    public function moons(): array
    {
        if (!isset($this->loadedMoons)) {
            $this->loadedMoons = json_decode(empty($this->moons) ? '[]' : strip_tags($this->moons), true);
        }
        return $this->loadedMoons;
    }

    /**
     * Get the calendar's seasons
     */
    public function seasons(): array
    {
        if (!isset($this->loadedSeasons)) {
            $this->loadedSeasons = json_decode(empty($this->seasons) ? '[]' : strip_tags($this->seasons), true);
        }
        return $this->loadedSeasons;
    }

    /**
     * Get the calendar's weeks
     */
    public function weeks(): array
    {
        if (!isset($this->loadedWeeks)) {
            $this->loadedWeeks = json_decode(empty($this->week_names) ? '[]' : strip_tags($this->week_names), true);
        }
        return $this->loadedWeeks;
    }

    /**
     * Get the calendar's month aliases
     */
    public function monthAliases(): array
    {
        if (!isset($this->loadedMonthAliases)) {
            $this->loadedMonthAliases = json_decode(empty($this->month_aliases) ? '[]' :
                strip_tags($this->month_aliases), true);
        }
        return $this->loadedMonthAliases;
    }

    /**
     */
    public function currentDate(?string $value = null): mixed
    {
        // If we have no date saved at all, skip this part. This happens when an entity was changed to the calendar
        // type and most fields are missing.
        if (empty($this->date)) {
            return null;
        }

        if ($value == 'year') {
            return $this->cacheCurrentDate()[0] ?? 0;
        } elseif ($value == 'month') {
            return $this->cacheCurrentDate()[1] ?? 1;
        } elseif ($value == 'date') {
            return $this->cacheCurrentDate()[2] ?? 1;
        }
        return null;
    }

    /**
     * Get the calendar's current date
     */
    public function currentYear(): int
    {
        return $this->cacheCurrentDate()[0] ?? 0;
    }

    /**
     * Get the calendar's current month
     */
    public function currentMonth(): int
    {
        return $this->cacheCurrentDate()[1] ?? 1;
    }

    /**
     * Get the calendar's current day
     */
    public function currentDay(): int
    {
        return $this->cacheCurrentDate()[2] ?? 1;
    }

    /**
     * Get the calendar's nice date
     */
    public function niceDate(?string $date = null): string
    {
        if (empty($date)) {
            $date = $this->date;
        }
        if (empty($date)) {
            return '';
        }

        list($year, $month, $day) = $this->dateArray($date);

        // Replace month with real month, and year maybe
        $months = $this->months();
        $years = $this->years();

        try {
            $return = $day . ' ' .
                (isset($months[$month - 1]) ? $months[$month - 1]['name'] : $month) . ', ' .
                ($years[$year] ?? $year) . ' ' .
                $this->suffix;
            return $return;
        } catch (Exception $e) { // @phpstan-ignore-line
            return $this->date;
        }
    }

    /**
     * Get a list of months for select fields
     */
    public function monthList(): array
    {
        $months = [];
        $i = 1;
        foreach ($this->months() as $month) {
            $months[$i] = $month['name'];
            $i++;
        }
        return $months;
    }

    /**
     * Get the length as a data-property for each of the calendar's months
     */
    public function monthDataProperties(): array
    {
        $monthData = [];
        $i = 1;
        foreach ($this->months() as $month) {
            $monthData[$i] = ['data-length' => $month['length']];
            $i++;
        }
        return $monthData;
    }

    /**
     * Build the list of days for a month
     */
    public function dayList(?int $month = null): array
    {
        if (empty($month)) {
            $month = $this->currentMonth();
        }
        $monthId = $month - ($month > 0 ? 1 : 0);
        $days = [];
        $currentMonth = $this->months()[$monthId];
        for ($i = 1; $i <= $currentMonth['length']; $i++) {
            $days[$i] = $i;
        }


        // No leaps days, or not on this month
        if (!$this->has_leap_year || $this->leap_year_month != $month) {
            return $days;
        }
        // We might be on a year with leap years, but the js is too complex so let's just assume
        $start = count($days);
        for ($i = 1; $i <= $this->leap_year_amount; $i++) {
            $day = $start + $i;
            $days[$day] = $day;
        }

        return $days;
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach(): void
    {
        foreach ($this->calendarEvents as $child) {
            $child->delete();
        }
    }

    /**
     * Determine if the calendar is missing months of weekdays to be rendered successfully
     */
    public function missingDetails(): bool
    {
        return count($this->months()) < 1 || count($this->weekdays()) < 2;
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.calendar');
    }

    /**
     * Cache the current date explode method
     */
    protected function cacheCurrentDate(): array
    {
        if (isset($this->cachedCurrentDate)) {
            return $this->cachedCurrentDate;
        }

        $date = mb_ltrim($this->date, '-');
        $this->cachedCurrentDate = explode('-', $date);

        if (str_starts_with($this->date, '-')) {
            $this->cachedCurrentDate[0] = '-' . $this->cachedCurrentDate[0];
        }

        return $this->cachedCurrentDate;
    }

    /**
     * Get the date as an array
     */
    public function dateArray(?string $date = null): array
    {
        if (empty($date)) {
            $date = $this->date;
        }

        $isNegativeYear = Str::startsWith($date, '-');
        $date = explode('-', mb_ltrim($date, '-'));

        if (count($date) !== 3) {
            return [1, 1, 1];
        }

        return [
            $isNegativeYear ? '-' . $date[0] : $date[0],
            max($date[1], 1),
            max($date[2], 1)
        ];
    }

    /**
     */
    public function recurringOptions(bool $flat = false): array
    {
        $options = [
            '' => __('calendars.options.events.recurring_periodicity.none'),
            'month' => __('calendars.options.events.recurring_periodicity.month'),
            'year' => __('calendars.options.events.recurring_periodicity.year'),
        ];

        // Add options based on moons
        $unnamed = 0;
        foreach ($this->moons() as $moon) {
            if ($flat) {
                $options[$moon['id'] . '_f'] = __('calendars.options.events.recurring_periodicity.fullmoon_name', ['moon' => $moon['name']]);
                $options[$moon['id'] . '_n'] = __('calendars.options.events.recurring_periodicity.newmoon_name', ['moon' => $moon['name']]);
                continue;
            }
            $name = $moon['name'];
            if (empty($name)) {
                $unnamed++;
                $name = __('calendars.options.events.recurring_periodicity.unnamed_moon', ['number' => $unnamed]);
            }
            $options[$name] = [
                $moon['id'] . '_f' => __('calendars.options.events.recurring_periodicity.fullmoon'),
                $moon['id'] . '_n' => __('calendars.options.events.recurring_periodicity.newmoon'),
            ];
        }

        return $options;
    }

    /**
     * Get the number of days in a year
     */
    public function daysInYear(): int
    {
        $days = 0;
        foreach ($this->months() as $month) {
            $days += Arr::get($month, 'length', 1);
        }
        return $days;
    }

    /**
     * Default calendar layout
     */
    public function defaultLayout(): string
    {
        return $this->yearlyLayout() ? 'year' : 'month';
    }

    /**
     * Determine if the calendar defaults to a yearly layout
     */
    public function yearlyLayout(): bool
    {
        return Arr::get($this->parameters, 'layout') === 'yearly';
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'calendar_id',
        ];
    }

    /**
     * Determine if the calendar skips year zero.
     */
    public function hasYearZero(): bool
    {
        return !$this->skip_year_zero;
    }
}
