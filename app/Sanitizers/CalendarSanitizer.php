<?php

namespace App\Sanitizers;

class CalendarSanitizer extends MiscSanitizer
{
    public function sanitize(): array
    {
        parent::sanitize();

        // Handle months
        $months = [];
        $monthCount = 0;
        $monthNames = $this->request->post('month_name', []);
        $monthLengths = $this->request->post('month_length', []);
        $monthAliases = $this->request->post('month_alias', []);
        $monthTypes = $this->request->post('month_type', []);
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
        $this->data['months'] = json_encode($months);

        // Handle weekdays
        $weekdays = [];
        $weekdayNames = $this->request->post('weekday', []);
        foreach ($weekdayNames as $name) {
            if (empty($name)) {
                continue;
            }

            $weekdays[] = $this->purify($name);
        }
        $this->data['weekdays'] = json_encode($weekdays);

        // Handle year names
        $years = [];
        $yearCount = 0;
        $yearValues = $this->request->post('year_number', []);
        $yearNames = $this->request->post('year_name', []);
        if (!empty($yearValues)) {
            foreach ($yearValues as $year) {
                if (empty($year)) {
                    continue;
                }
                // Save the leap year
                $years[$year] = $this->purify($yearNames[$yearCount]);
                $yearCount++;
            }
        }
        $this->data['years'] = json_encode($years);

        // Handle week names
        $weeks = [];
        $weekCount = 0;
        $weekValues = $this->request->post('week_number', []);
        $weekNames = $this->request->post('week_name', []);
        if (!empty($weekValues)) {
            foreach ($weekValues as $week) {
                if (empty($week)) {
                    continue;
                }
                // Save the leap year
                $weeks[$week] = $this->purify($weekNames[$weekCount]);
                $weekCount++;
            }
        }
        $this->data['week_names'] = json_encode($weeks);

        // Handle moons
        $moons = [];
        $moonCount = 0;
        $moonValues = $this->request->post('moon_fullmoon', []);
        $moonNames = $this->request->post('moon_name', []);
        $moonOffsets = $this->request->post('moon_offset', []);
        $moonColours = $this->request->post('moon_colour', []);
        $moonIds = $this->request->post('moon_id', []);

        // Get the highest moon id
        $autoMoonId = 0;
        foreach ($moonIds as $id) {
            if (!empty($id) && $id > $autoMoonId) {
                $autoMoonId = $id;
            }
        }
        $autoMoonId++;

        if ($moonValues) {
            foreach ($moonValues as $moon) {
                if (empty($moon)) {
                    continue;
                }

                $moonId = $moonIds[$moonCount];
                if (empty($moonId)) {
                    $moonId = $autoMoonId;
                    $autoMoonId++;
                }

                $moons[] = [
                    'name' => $this->purify($moonNames[$moonCount]),
                    'fullmoon' => round($moon, 3),
                    'offset' => (int) $moonOffsets[$moonCount],
                    'colour' => $this->purify($moonColours[$moonCount]),
                    'id' => (int) $moonId,
                ];
                $moonCount++;
            }
        }
        $this->data['moons'] = json_encode($moons);

        // Handle seasons
        $seasons = [];
        $seasonCount = 0;
        $seasonNames = $this->request->post('season_name', []);
        $seasonMonths = $this->request->post('season_month', []);
        $seasonDays = $this->request->post('season_day', []);
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
        $this->data['seasons'] = json_encode($seasons);

        // Calculate date
        $year = $this->request->post('current_year', '1');
        $month = ltrim($this->request->post('current_month', '1'), '0');
        $day = ltrim($this->request->post('current_day', '1'), '0');

        // Empty values and skipping year 0
        if ($year === null || $this->request->skip_year_zero && $year == 0) {
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

        $this->data['date'] = "{$year}-{$month}-{$day}";

        // Leap year
        if ($this->request->has_leap_year) {
            if ($this->request->leap_year_month < 1) {
                $this->data['leap_year_month'] = 1;
            } elseif ($this->request->leap_year_month > count($months)) {
                $this->data['leap_year_month'] = count($months);
            }
        }

        return $this->data;
    }
}
