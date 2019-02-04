<?php

namespace App\Observers;

use App\Models\MiscModel;
use Illuminate\Support\Facades\Session;

class CalendarObserver extends MiscObserver
{
    /**
     * Before the calendar model is saved
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        if (!request()->has('name') || $model->savingObserver === false) {
            return;
        }

        // Handle months
        $months = [];
        $monthCount = 0;
        $monthNames = request()->post('month_name');
        $monthLengths = request()->post('month_length');
        foreach ($monthNames as $name) {
            if (empty($name)) {
                continue;
            }

            // We want a month length of at least 1 day
            $length = (int) $monthLengths[$monthCount];
            $months[] = [
                'name' => $name,
                'length' => $length < 1 ? 1 : $length
            ];
            $monthCount++;
        }
        $model->months = json_encode($months);

        // Handle weekdays
        $weekdays = [];
        $weekdayNames = request()->post('weekday');
        foreach ($weekdayNames as $name) {
            if (empty($name)) {
                continue;
            }

            $weekdays[] = $name;
        }
        $model->weekdays = json_encode($weekdays);

        // Handle year names
        $years = [];
        $yearCount = 0;
        $yearValues = request()->post('year_number');
        $yearNames = request()->post('year_name');
        if ($yearValues) {
            foreach ($yearValues as $year) {
                if (empty($year)) {
                    continue;
                }
                // Save the leap year
                $years[$year] = $yearNames[$yearCount];
                $yearCount++;
            }
        }
        $model->years = json_encode($years);

        // Handle moons
        $moons = [];
        $moonCount = 0;
        $moonValues = request()->post('moon_fullmoon');
        $moonNames = request()->post('moon_name');
        if ($moonValues) {
            foreach ($moonValues as $moon) {
                if (empty($moon)) {
                    continue;
                }
                // Save the leap moon
                $moons[$moon] = $moonNames[$moonCount];
                $moonCount++;
            }
        }
        $model->moons = json_encode($moons);

        // Handle moons
        $seasons = [];
        $seasonCount = 0;
        $seasonNames = request()->post('season_name');
        $seasonMonths = request()->post('season_month');
        $seasonDays = request()->post('season_day');
        foreach ($seasonNames as $name) {
            if (empty($name)) {
                continue;
            }

            // We want a season length of at least 1 day
            $month = (int) $seasonMonths[$seasonCount];
            $day = (int) $seasonDays[$seasonCount];
            $seasons[] = [
                'name' => $name,
                'month' => $month < 1 ? 1 : $month,
                'day' => $day,
            ];
            $seasonCount++;
        }
        $model->seasons = json_encode($seasons);

        // Calculate date
        $year = request()->post('current_year', 1);
        $month = request()->post('current_month', 1);
        $day = request()->post('current_day', 1);

        // Empty values
        if (empty($year)) {
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
