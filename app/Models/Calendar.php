<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
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
 * @property array $parameters
 *
 * @property EntityEvent[] $calendarEvents
 * @property CalendarWeather[] $calendarWeather
 * @property Calendar|null $calendar
 */
class Calendar extends MiscModel
{
    use CampaignTrait,
        ExportableTrait,
        SoftDeletes,
        Acl
    ;

    /** @var string[]  */
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

    /** @var array<string, string> */
    public $casts = [
        'parameters' => 'array'
    ];

    /** @var bool|array */
    protected $loadedMonths = false;

    /** @var bool|array */
    protected $loadedWeekdays = false;

    /** @var bool|array */
    protected $loadedYears = false;

    /** @var bool|array */
    protected $loadedSeasons = false;

    /** @var bool|array */
    protected $loadedMoons = false;

    /** @var bool|array */
    protected $loadedWeeks = false;

    /** @var bool|array */
    protected $loadedMonthAliases = false;

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'calendar';

    /**
     * @var bool|array
     */
    protected $cachedCurrentDate = false;

    /**
     * @var bool|Collection
     */
    protected $cachedRecurringEvents = false;

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext');
            },
            'calendars' => function ($sub) {
                $sub->select('id', 'name', 'calendar_id');
            }
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
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
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['calendar_id', 'date'];
    }

    /**
     * @param int $take
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function dashboardEvents(string $operator = '=', int $take = 5, bool $recurring = false)
    {
        $order = $operator == '<' ? 'DESC' : 'ASC';
        $query = $this->calendarEvents()
            ->with(['entity', 'calendar'])
            ->has('entity')
            ->where(function ($sub) use ($operator, $recurring) {
                // Recurring events
                if ($recurring) {
                    $sub->orWhere(function ($subsub) {
                        $subsub
                            ->where('is_recurring', true)
                            // We want recurring events that will start in the future, just in case. Limit it to +2
                            // years to avoid performance drop
                            ->where('year', '<=', $this->currentYear() + 2)
                            ->where(function ($datesub) {
                                $datesub->whereNull('recurring_until')
                                    ->orWhereRaw("recurring_until >= '" . $this->currentYear() . "'");
                            });
                    });
                } else {
                    $sub->where('year', $operator, $this->currentYear());
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
     * Get the months decoded from the json into a usable array
     * @return array
     */
    public function months()
    {
        if ($this->loadedMonths !== false) {
            return $this->loadedMonths;
        }
        return (array) $this->loadedMonths = !empty($this->months) ?
            json_decode(strip_tags($this->months), true) : [];
    }

    /**
     * Get the weekdays
     * @return null|array
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
     * @return null|array
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
     * @return null|array
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
     * @return null|array
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
     * @return null|array
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
     * @return null|array
     */
    public function monthAliases()
    {
        if ($this->loadedMonthAliases === false) {
            $this->loadedMonthAliases = json_decode(empty($this->month_aliases) ? '[]' : strip_tags($this->month_aliases), true);
        }
        return $this->loadedMonthAliases;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function currentDate($value)
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
     * @return int
     */
    public function currentYear(): int
    {
        return $this->cacheCurrentDate()[0] ?? 0;
    }

    /**
     * Get the calendar's current month
     * @return int
     */
    public function currentMonth(): int
    {
        return $this->cacheCurrentDate()[1] ?? 1;
    }

    /**
     * Get the calendar's current day
     * @return int
     */
    public function currentDay(): int
    {
        return $this->cacheCurrentDate()[2] ?? 1;
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

        list($year, $month, $day) = $this->dateArray($date);

        // Replace month with real month, and year maybe
        $months = $this->months();
        $years = $this->years();

        try {
            $return = $day . ' ' .
                (isset($months[$month - 1]) ? $months[$month - 1]['name'] : $month) . ', ' .
                (isset($years[$year]) ? $years[$year] : $year) . ' ' .
                $this->suffix;
            return $return;
        } catch (\Exception $e) { // @phpstan-ignore-line
            return $this->date;
        }
    }

    /**
     * Get a list of months for select fields
     * @return array
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
     * @return array
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
     * @param int|null $month
     * @return array
     */
    public function dayList(int $month = null): array
    {
        if (empty($month)) {
            $month = $this->currentMonth();
        }
        $month = $month - ($month > 0 ? 1 : 0);
        $days = [];
        $currentMonth = $this->months()[$month];
        for ($i = 1; $i <= $currentMonth['length']; $i++) {
            $days[$i] = $i;
        }

        return $days;
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
            $day = ((int) $segments[2]) + 1;
            if ($day > $months[$month - 1]['length']) {
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
        list($year, $month, $day) = $this->dateArray();

        $day--;
        $months = $this->months();
        if ($day < 1) {
            $month--;
            if ($month < 1) {
                $month = count($months);
                $year--;
            }
            $day = $months[$month - 1]['length'];
        }

        $this->date = $year . '-' . $month . '-' . $day;
        return $this->save();
    }

    /**
     * @return bool
     */
    public function missingDetails()
    {
        return count($this->months()) < 1 || count($this->weekdays()) < 2;
    }

    /**
     * @return array
     */
    public function menuItems(array $items = []): array
    {
        $count = $this->calendarEvents()->has('entity')->count();
        if ($count > 0) {
            $items['second']['events'] = [
                'name' => 'crud.tabs.reminders',
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
    protected function cacheCurrentDate(): array
    {
        if ($this->cachedCurrentDate !== false) {
            return $this->cachedCurrentDate;
        }

        $date = ltrim($this->date, '-');
        $this->cachedCurrentDate = explode('-', $date);

        if (str_starts_with($this->date, '-')) {
            $this->cachedCurrentDate[0] = '-' . $this->cachedCurrentDate[0];
        }

        return $this->cachedCurrentDate;
    }

    /**
     * Get the date as an array
     * @return array
     */
    protected function dateArray(string $date = null): array
    {
        if (empty($date)) {
            $date = $this->date;
        }

        $isNegativeYear = Str::startsWith($date, '-');
        $date = explode('-', ltrim($date, '-'));

        if (count($date) !== 3) {
            return [1, 1, 1];
        }

        return [
            $isNegativeYear ? '-' . $date[0] : $date[0],
            $date[1],
            $date[2]
        ];
    }

    /**
     * @param bool $flat
     * @return array
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
     * @param int $needle the number of elements analyzed
     * @return Collection
     */
    public function upcomingEvents(int $needle = 10): Collection
    {
        $upcomingEvents = new Collection();

        $currentYear = $this->currentYear();
        $currentMonth = $this->currentMonth();
        $currentDay = $this->currentDay();

        // Loop through reminders occurring on this year, and sort them out in upcoming and past.
        // Todo: only take a few close to the current date?
        foreach ($this->recurringEvents() as $reminder) {
            if ($reminder->isPast($this)) {
                continue;
            }
            $upcomingEvents->push($reminder);
        }

        // If we need more upcoming events, get some
        if ($upcomingEvents->count() < $needle) {
            $upcomingSingleEvents = $this->dashboardEvents('>');
            foreach ($upcomingSingleEvents as $reminder) {
                $upcomingEvents->push($reminder);
            }
        }

// Get the recurring events separately to make sure we always have 5 real "upcoming" events that mix recurring and single
        $upcomingRecurringEvents = $this->dashboardEvents('>=', $needle, true);
        foreach ($upcomingRecurringEvents as $event) {
            // Recurring events can be forever, so check that's best
            $until = !empty($event->recurring_until) ? min($event->recurring_until, $currentYear + 5) : $currentYear + 5;
            for ($y = $currentYear; $y < $until; $y++) {
                if ($y <= $currentYear && ($event->month < $this->currentMonth() || ($event->month == $currentMonth && $event->day < $currentDay))) {
                    continue;
                }
                // Make a copy to change the date
                $e = clone($event);
                $e->year = $y;
                $upcomingEvents->push($e);
            }
        }
        // Order the upcoming events by date
        $upcomingEvents = $upcomingEvents->sortBy(function ($reminder) {
            return [$reminder->year, $reminder->month, $reminder->day];
        });

        return $upcomingEvents;
    }

    /**
     * Look at events to calculate the most upcoming events for the calendar
     * dashboard widget.
     * @param int $needle
     * @return Collection
     */
    public function upcomingReminders(int $needle = 10): Collection
    {
        $reminders = $this->calendarEvents()
            ->with(['entity'])
            ->has('entity')
            ->where(function ($primary) {
                $primary->where(function ($sub) {
                    $sub->where(function ($recurring) {
                        $recurring
                            ->where('is_recurring', true)
                            ->whereIn('recurring_periodicity', ['year', 'month'])
                            ->where(function ($recurringuntil) {
                                $recurringuntil
                                    ->whereNull('recurring_until')
                                    // Events that end in the future are fine, they could be reoccuring on this month
                                    ->orWhere('recurring_until', '>=', $this->currentYear());
                            });
                    });
                })
                ->orWhere(function ($ondate) {
                    // Not recurring
                    $ondate
                        ->where('is_recurring', false)
                        ->where(function ($date) {
                            // An event that happens before this year
                            $date
                                ->where('year', '>', $this->currentYear())
                                ->orWhere(function ($subdate) {
                                    // An event that happens this year but after this month
                                    $subdate
                                        ->where('year', $this->currentYear())
                                        ->where('month', '>', $this->currentMonth());
                                })
                                ->orWhere(function ($subdate) {
                                    // An event that happens this year after this year
                                    $subdate
                                        ->where('year', $this->currentYear())
                                        ->where('month', $this->currentMonth())
                                        ->where('day', '>=', $this->currentDay());
                                });
                        });
                });
            })
            // Skip events that were on months which no longer exist
            ->where('month', '<=', count($this->months()))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->orderBy('day', 'asc')
            ->take($needle)
            ->get();


        // Order the past events in descending date to get the closest ones to the current date first
        return $reminders->sortBy(function ($reminder) {
            // For some reason, when using with(calendar), it loads the wrong ids?
            $reminder->calendar = $this;
            return $reminder->nextUpcomingOccurrence(
                $this->currentYear(),
                $this->currentMonth(),
                $this->currentDay(),
                $this->months(),
                $this->daysInYear()
            );
        });
    }

    /**
     * Look at events to calculate the most recently occuring events for the calendar
     * dashboard widget.
     * @param int $needle
     * @return Collection
     */
    public function pastReminders(int $needle = 10): Collection
    {
        $reminders = $this->calendarEvents()
            ->with(['entity'])
            ->has('entity')
            ->where(function ($primary) {
                $primary->where(function ($sub) {
                    $sub->where(function ($recurring) {
                        $recurring
                            ->where('is_recurring', true)
                            ->whereIn('recurring_periodicity', ['year', 'month'])
                            ->where(function ($recurringuntil) {
                                $recurringuntil
                                    ->whereNull('recurring_until')
                                    // Events that end in the future are fine, they could be reoccuring on this month
                                    ->orWhere('recurring_until', '>=', $this->currentYear());
                            })
                            ->where('year', '<=', $this->currentYear());
                    });
                })
                    ->orWhere(function ($ondate) {
                        // Not recurring
                        $ondate
                            ->where('is_recurring', false)
                            ->where(function ($date) {
                                // An event that happens before this year
                                $date
                                    ->where('year', '<', $this->currentYear())
                                    ->orWhere(function ($subdate) {
                                        // An event that happens this year but before this month
                                        $subdate
                                            ->where('year', $this->currentYear())
                                            ->where('month', '<', $this->currentMonth());
                                    })
                                    ->orWhere(function ($subdate) {
                                        // An event that happens this year but before this day
                                        $subdate
                                            ->where('year', $this->currentYear())
                                            ->where('month', $this->currentMonth())
                                            ->where('day', '<', $this->currentDay());
                                    });
                            });
                    });
            })
            // Skip events that were on months which no longer exist
            ->where('month', '<=', count($this->months()))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc')
            ->take($needle)
            ->get();

        // Order the past events in descending date to get the closest ones to the current date first
        return $reminders->sortBy(function ($reminder) {
            // For some reason, when using with(calendar), it loads the wrong ids?
            $reminder->calendar = $this;
            return $reminder->mostRecentOccurrence(
                $this->currentYear(),
                $this->currentMonth(),
                $this->currentDay(),
                $this->months(),
                $this->daysInYear()
            );
        });
    }

    /**
     * @return bool|\Illuminate\Database\Eloquent\Collection|Collection
     */
    protected function recurringEvents()
    {
        if ($this->cachedRecurringEvents !== false) {
            return $this->cachedRecurringEvents;
        }

        return $this->cachedRecurringEvents = $this->dashboardEvents('=', 0);
    }

    /**
     * Get the number of days in a year
     * @return int
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
     * @return string
     */
    public function defaultLayout(): string
    {
        return $this->yearlyLayout() ? 'year' : 'month';
    }

    /**
     * @return bool
     */
    public function yearlyLayout(): bool
    {
        return !empty($this->parameters['layout']) && $this->parameters['layout'] === 'yearly';
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
}
