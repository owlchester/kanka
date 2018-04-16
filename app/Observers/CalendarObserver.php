<?php

namespace App\Observers;

use App\Models\MiscModel;
use Illuminate\Support\Facades\Session;

class CalendarObserver extends MiscObserver
{
    public function saving(MiscModel $model)
    {
        parent::saving($model);


        // Handle months
        $months = [];
        $monthCount = 0;
        $monthNames = request()->post('month_name');
        $monthLengths = request()->post('month_length');
        foreach ($monthNames as $name) {
            if (empty($name)) {
                continue;
            }

            $months[] = [
                'name' => $name,
                'length' => $monthLengths[$monthCount]
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

        // Calculate date
        $year = request()->post('current_year');
        $month = request()->post('current_month');
        $day = request()->post('current_day');

        // Fix date?
        if ($month > ($monthCount)) {
            $month = $monthCount;
        }
        if (isset($monthLengths[$month - 1])) {
            if ($day > $monthLengths[$month - 1]) {
                $day = $monthLengths[$month - 1];
            } else {
                $day = 1;
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
