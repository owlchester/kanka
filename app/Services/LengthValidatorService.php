<?php

namespace App\Services;

use App\Http\Requests\ValidateReminderLength as Request;
use App\Models\Calendar;

class LengthValidatorService
{
    /**
     * @return array
     */
    public function validateLength(Calendar $calendar, Request $request)
    {
        $day = $request['day'] ?? 0;
        $month = $request['month'];
        $length = $request['length'];

        $daysInYear = $calendar->daysInYear();
        $counter = 0;
        $monthLength = 0;
        foreach ($calendar->monthDataProperties() as $monthData) {
            $counter = $counter + 1;
            if ($counter >= $month) {
                $monthLength = $monthLength + $monthData['data-length'];
            }
        }
        $totalLength = $monthLength - $day + $daysInYear;
        if ($length >= $totalLength) {
            return [
                'overflow' => true,
                'message' => __('calendars.warnings.event_length', ['documentation' => '<a href="https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders"  class="text-link"><i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation') . '</a>',
                ])];
        }

        return [
            'overflow' => false,
            'message' => __('calendars.warnings.event_length', ['documentation' => '<a href="https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders" class="text-link"><i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation') . '</a>',
            ])];
    }
}
