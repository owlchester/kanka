<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Calendar
 * @package App\Models
 *
 * @property string $date
 * @property integer $start_offset
 * @property string $months
 * @property string $years
 * @property string $weekdays
 * @property string $week_names
 * @property string $month_aliases
 * @property string $seasons
 * @property string $moons
 * @property string $reset
 * @property int $calendar_id
 *
 * @property CalendarEvent[] $calendarEvents
 * @property CalendarWeather[] $calendarWeather
 * @property Calendar $calendar
 */
class Calendar extends MiscModel
{
    use CampaignTrait,
        VisibleTrait,
        ExportableTrait,
        SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'entry',
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
        'epochs',
        'month_aliases',
        'week_names',
        'reset',
        'is_incrementing',

        // Leap year
        'has_leap_year',
        'leap_year_amount', // Add X number of days
        'leap_year_month', // At the end of month X
        'leap_year_offset', // every X years
        'leap_year_start', // X year is a leap year

        'calendar_id',
    ];

    /**
     * Parameters in decoded json
     * @var bool
     */
    protected $params = false;

    /**
     * @var bool
     */
    protected $loadedMonths = false;

    /**
     * @var bool
     */
    protected $loadedWeekdays = false;

    /**
     * @var bool
     */
    protected $loadedYears = false;

    /**
     * @var bool
     */
    protected $loadedSeasons = false;

    /**
     * @var bool
     */
    protected $loadedMoons = false;

    /**
     * @var bool
     */
    protected $loadedWeeks = false;

    /**
     * @var bool
     */
    protected $loadedMonthAliases = false;

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'tag_id',
        'is_private',
        'tags',
        'has_image',
        'calendar_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'calendar';

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'entry', 'type'];

    protected $cachedCurrentDate = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function events()
    {
        return $this->hasManyThrough(
            'App\Models\Event',
            EntityEvent::class,
            'calendar_id',
            'entity_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarEvents()
    {
        return $this->hasMany(EntityEvent::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarWeather()
    {
        return $this->hasMany(CalendarWeather::class, 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * @param int $take
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function dashboardEvents($operator = '=', $take = 5, $recurring = false)
    {
        $this->cacheCurrentDate();
        $order = $operator == '<' ? 'DESC' : 'ASC';
        $query = $this->calendarEvents()
            ->with(['entity', 'calendar'])
            ->entityAcl()
            ->where(function ($sub) use ($operator, $recurring) {
                // Recurring events
                if ($recurring) {
                    $sub->orWhere(function ($subsub) {
                        $subsub
                            ->where('is_recurring', true)
                            // We want recurring events that will start in the future, just in case. Limit it to +2
                            // years to avoid performance drop
                            ->where('year', '<=', Arr::get($this->cachedCurrentDate, 0, 1) + 2)
                            ->where(function ($datesub) {
                                $datesub->whereNull('recurring_until')
                                    ->orWhereRaw("recurring_until >= '" . $this->currentDate('year') . "'");
                            });
                    });
                } else {
                    $sub->where('year', $operator, Arr::get($this->cachedCurrentDate, 0, 1));
                    $sub->where('is_recurring', false);
                    //$sub->whereRaw("date(`date`) $operator '" . $this->date . "'");
                }
            })
            ->orderBy('year', $order)
            ->orderBy('month', $order)
            ->orderBy('day', $order);

        if (!empty($take)) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * Get the months
     * @return null
     */
    public function months()
    {
        if ($this->loadedMonths === false) {
            $this->loadedMonths = [];
            if (!empty($this->months)) {
                $this->loadedMonths = json_decode(strip_tags($this->months), true);
            }
        }
        return $this->loadedMonths;
    }

    /**
     * Get the weekdays
     * @return null
     */
    public function weekdays()
    {
        if ($this->loadedWeekdays === false) {
            $this->loadedWeekdays = [];
            if (!empty($this->months)) {
                $this->loadedWeekdays = json_decode(strip_tags($this->weekdays), true);
            }
        }
        return $this->loadedWeekdays;
    }

    /**
     * Get the weekdays
     * @return null
     */
    public function years()
    {
        if ($this->loadedYears === false) {
            $this->loadedYears = [];
            if (!empty($this->years)) {
                $this->loadedYears = json_decode(strip_tags($this->years), true);
            }
        }
        return $this->loadedYears;
    }


    /**
     * Get the moons
     * @return null
     */
    public function moons()
    {
        if ($this->loadedMoons === false) {
            $this->loadedMoons = json_decode(empty($this->moons) ? '[]' : strip_tags($this->moons), true);
        }
        return $this->loadedMoons;
    }

    /**
     * Get the seasons
     * @return null
     */
    public function seasons()
    {
        if ($this->loadedSeasons === false) {
            $this->loadedSeasons = json_decode(empty($this->seasons) ? '[]' : strip_tags($this->seasons), true);
        }
        return $this->loadedSeasons;
    }

    /**
     * Get the weeks
     * @return null
     */
    public function weeks()
    {
        if ($this->loadedWeeks === false) {
            $this->loadedWeeks = json_decode(empty($this->week_names) ? '[]' : strip_tags($this->week_names), true);
        }
        return $this->loadedWeeks;
    }

    /**
     * Get the month aliases
     * @return null
     */
    public function monthAliases()
    {
        if ($this->loadedMonthAliases === false) {
            $this->loadedMonthAliases = json_decode(empty($this->month_aliases) ? '[]' : strip_tags($this->month_aliases), true);
        }
        return $this->loadedMonthAliases;
    }

    /**
     * Get the value of a parameter
     * @param $field
     * @return null
     */
    private function param($field)
    {
        if ($this->params === false) {
            $this->params = json_decode(strip_tags($this->parameters), true);
        }

        if (isset($this->params[$field])) {
            return $this->params[$field];
        }

        return null;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function currentDate($value)
    {
        // If we have no date saved at all, skip this part. This happens when an entity was changed to the calendar
        // type and most fields are missing.
        if (empty($this->date)) {
            return null;
        }

        $this->cacheCurrentDate();
        if ($value == 'year') {
            return $this->cachedCurrentDate[0] ?: 0;
        } elseif ($value == 'month') {
            return $this->cachedCurrentDate[1] ?: 1;
        } elseif ($value == 'date') {
            return $this->cachedCurrentDate[2] ?? 1;
        }
        return null;
    }

    /**
     * Get the calendar's nice date
     * @return mixed|string
     */
    public function niceDate($date = null)
    {
        if (empty($date)) {
            $date = $this->date;
        }
        $isNegativeYear = Str::startsWith($date, '-');
        $date = explode('-', ltrim($date, '-'));

        // Replace month with real month, and year maybe
        $months = $this->months();
        $years = $this->years();

        try {
            $date[0] = $isNegativeYear ? '-' . $date[0] : $date[0];
            return $date[2] . ' ' .
                (isset($months[$date[1] - 1]) ? $months[$date[1] - 1]['name'] : $date[1]) . ', ' .
                (isset($years[$date[0]]) ? $years[$date[0]] : $date[0]) . ' ' .
                $this->suffix;
        } catch (\Exception $e) {
            return $this->date;
        }
    }

    /**
     * Get a list of months for select fields
     * @return array
     */
    public function monthList()
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
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->calendarEvents as $child) {
            $child->delete();
        }

        return parent::detach();
    }

    /**
     * Add a day to the calendar's current date
     * @return bool
     */
    public function addDay()
    {
        $segments = explode('-', ltrim($this->date, '-'));
        $year = ($this->date[0] == '-' ? '-' : null) . $segments[0];
        $month = $segments[1] ?? 1;
        $day = false;

        // Day is longer than month max length?
        $months = $this->months();

        if (!empty($segments[2])) {
            $day = $segments[2] + 1;
            if ($day > $months[$month-1]['length']) {
                $day = 1;
                $month++;
            }
        } else {
            $month++;
        }

        // Reset month and increment year
        if ($month > count($months)) {
            $month = 1;
            $year++;
        }

        $this->date = $year . '-' . $month . ($day !== false ? '-' . $day : null);
        return $this->save();
    }

    /**
     * Substract one day from the calendar's current date
     * @return bool
     */
    public function subDay()
    {
        list($year, $month, $day) = explode('-', $this->date);

        $day--;
        $months = $this->months();
        if ($day < 1) {
            $month--;
            if ($month < 1) {
                $month = count($months);
                $year--;
            }
            $day = $months[$month-1]['length'];
        }

        $this->date = $year . '-' . $month . '-' . $day;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function missingDetails()
    {
        return count($this->months()) < 2 || count($this->weekdays()) < 2;
    }

    /**
     * @return array
     */
    public function menuItems($items = []): array
    {
        $count = $this->calendarEvents()->entityAcl()->count();
        if ($count > 0) {
            $items['events'] = [
                'name' => 'calendars.show.tabs.events',
                'route' => 'calendars.events',
                'count' => $count
            ];
        }
        return parent::menuItems($items);
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.calendar');
    }

    /**
     * Cache the current date explode method
     */
    protected function cacheCurrentDate(): void
    {
        if ($this->cachedCurrentDate !== false) {
            return;
        }

        $date = ltrim($this->date, '-');
        $this->cachedCurrentDate = explode('-', $date);

        if (substr($this->date, 0, 1) == '-') {
            $this->cachedCurrentDate[0] = -$this->cachedCurrentDate[0];
        }
    }
}
