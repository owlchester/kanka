<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

/**
 * Class Calendar
 * @package App\Models
 * @var integer $campaign_id
 * @var string $date
 * @var string $name
 */
class Calendar extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'type',
        'entry',
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

        // Leap year
        'has_leap_year',
        'leap_year_amount', // Add X number of days
        'leap_year_month', // At the end of month X
        'leap_year_offset', // every X years
        'leap_year_start', // X year is a leap year
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
    protected $loadedIntercalaries = false;

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'tag_id',
        'is_private',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use ExportableTrait;

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
            'App\Models\EntityEvent',
            'calendar_id',
            'entity_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendarEvents()
    {
        return $this->hasMany('App\Models\EntityEvent', 'calendar_id');
    }

    /**
     * @param int $take
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function dashboardEvents($operator = '=', $take = 5, $recurring = false)
    {
        return $this->calendarEvents()
            ->with(['entity', 'calendar'])
            ->entityAcl()
            ->where(function ($sub) use ($operator, $recurring) {
                // Recurring events
                if ($recurring) {
                    $sub->orWhere(function ($subsub) {
                        $subsub
                            ->where('is_recurring', true)
                            ->whereRaw("date(`date`) < '" . $this->date . "'")
                            ->where(function ($datesub) {
                                $datesub->whereNull('recurring_until')
                                    ->orWhereRaw("recurring_until >= '" . $this->currentDate('year') . "'");
                            });
                    });
                } else {
                    $sub->whereRaw("date(`date`) $operator '" . $this->date . "'");
                }
            })
            ->take($take)
            ->orderByRaw('date(`date`) ' . ($operator == '<' ? 'desc' : 'asc'))
            ->get();
    }

    /**
     * Get the months
     * @return null
     */
    public function months()
    {
        if ($this->loadedMonths === false) {
            $this->loadedMonths = json_decode(strip_tags($this->months), true);
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
            $this->loadedWeekdays = json_decode(strip_tags($this->weekdays), true);
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
            $this->loadedYears = json_decode(strip_tags($this->years), true);
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
        $data = explode('-', $this->date);
        if ($value == 'year') {
            return $data[0];
        } elseif ($value == 'month') {
            return $data[1];
        } elseif ($value == 'date') {
            return $data[2];
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
        $date = explode('-', $date);

        // Replace month with real month, and year maybe
        $months = $this->months();
        $years = $this->years();

        try {
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
        list($year, $month, $day) = explode('-', $this->date);

        $day++;
        // Day is longer than month max length?
        $months = $this->months();
        if ($day > $months[$month-1]['length']) {
            $day = 1;
            $month++;
            if ($month > count($months)) {
                $month = 1;
                $year++;
            }
        }

        $this->date = $year . '-' . $month . '-' . $day;
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
    public function menuItems($items = [])
    {
        $campaign = $this->campaign;

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
}
