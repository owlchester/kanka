<?php

namespace App\Observers;

use App\Models\Calendar;
use App\Models\MiscModel;
use Illuminate\Support\Facades\Session;

class CalendarObserver extends MiscObserver
{
    /**
     * Before the calendar model is saved
     * @param Calendar $model
     */
    public function saving(MiscModel $model)
    {
        /** @var Calendar $model */
        parent::saving($model);

        // Only go further if we have a name field (coming from the calendar's form)
        if (!request()->has('name') || $model->savingObserver === false) {
            return;
        }

        // Handle months
        $months = [];
        $monthCount = 0;
        $monthNames = request()->post('month_name', []);
        $monthLengths = request()->post('month_length', []);
        $monthAliases= request()->post('month_alias', []);
        $monthTypes = request()->post('month_type', []);
        foreach ($monthNames as $name) {
            if (empty($name)) {
                continue;
            }

            // We want a month length of at least 1 day
            $length = (int) $monthLengths[$monthCount];
            $months[] = [
                'name' => $this->purify($name),
                'length' => $length < 1 ? 1 : $length,
                'type' => $monthTypes[$monthCount] ?? 'standard',
                'alias' => $this->purify($monthAliases[$monthCount] ?? ''),
            ];
            $monthCount++;
        }
        $model->months = json_encode($months);

        // Handle weekdays
        $weekdays = [];
        $weekdayNames = request()->post('weekday', []);
        foreach ($weekdayNames as $name) {
            if (empty($name)) {
                continue;
            }

            $weekdays[] = $this->purify($name);
        }
        $model->weekdays = json_encode($weekdays);

        // Handle year names
        $years = [];
        $yearCount = 0;
        $yearValues = request()->post('year_number', []);
        $yearNames = request()->post('year_name', []);
        if ($yearValues && !empty($yearValues)) {
            foreach ($yearValues as $year) {
                if (empty($year)) {
                    continue;
                }
                // Save the leap year
                $years[$year] = $this->purify($yearNames[$yearCount]);
                $yearCount++;
            }
        }
        $model->years = json_encode($years);

        // Handle week names
        $weeks = [];
        $weekCount = 0;
        $weekValues = request()->post('week_number', []);
        $weekNames = request()->post('week_name', []);
        if ($weekValues && !empty($weekValues)) {
            foreach ($weekValues as $week) {
                if (empty($week)) {
                    continue;
                }
                // Save the leap year
                $weeks[$week] = $this->purify($weekNames[$weekCount]);
                $weekCount++;
            }
        }
        $model->week_names = json_encode($weeks);

        // Handle moons
        $moons = [];
        $moonCount = 0;
        $moonValues = request()->post('moon_fullmoon', []);
        $moonNames = request()->post('moon_name', []);
        $moonOffsets = request()->post('moon_offset', []);
        $moonColours = request()->post('moon_colour', []);
        if ($moonValues) {
            foreach ($moonValues as $moon) {
                if (empty($moon)) {
                    continue;
                }

                $moons[] = [
                    'name' => $this->purify($moonNames[$moonCount]),
                    'fullmoon' => round($moon, 3),
                    'offset' => (int) $moonOffsets[$moonCount],
                    'colour' => $this->purify($moonColours[$moonCount]),
                ];
                $moonCount++;
            }
        }
        $model->moons = json_encode($moons);

        // Handle seasons
        $seasons = [];
        $seasonCount = 0;
        $seasonNames = request()->post('season_name', []);
        $seasonMonths = request()->post('season_month', []);
        $seasonDays = request()->post('season_day', []);
        foreach ($seasonNames as $name) {
            if (empty($name)) {
                continue;
            }

            // We want a season length of at least 1 day
            $month = (int) $seasonMonths[$seasonCount];
            $day = (int) $seasonDays[$seasonCount];
            $seasons[] = [
                'name' => $this->purify($name),
                'month' => $month < 1 ? 1 : $month,
                'day' => $day,
            ];
            $seasonCount++;
        }
        $model->seasons = json_encode($seasons);

        // Calculate date
        $year = request()->post('current_year', 1);
        $month = ltrim(request()->post('current_month', 1), 0);
        $day = ltrim(request()->post('current_day', 1), 0);

        // Empty values
        if ($year === null) {
            $year = 1;
        }
        if (empty($month)) {
            $month = 1;
        }
        if (empty($day)) {
            $day = 1;
        }

        // Fix date?
        if ($month > ($monthCount)) {
            $month = $monthCount;
        }
        if (isset($monthLengths[$month - 1])) {
            if ($day > $monthLengths[$month - 1]) {
                $day = $monthLengths[$month - 1];
            }
        }

        $model->date = "$year-$month-$day";

        // Leap year
        if ($model->has_leap_year) {
            if ($model->leap_year_month < 1) {
                $model->leap_year_month = 1;
            } elseif ($model->leap_year_month > count($months)) {
                $model->leap_year_month = count($months);
            }
        }
    }
}
