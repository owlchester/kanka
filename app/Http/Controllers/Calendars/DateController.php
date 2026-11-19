<?php

namespace App\Http\Controllers\Calendars;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Campaign;
use App\Services\Calendars\RecurrenceOptionsService;

class DateController extends Controller
{
    public function monthList(Campaign $campaign, Calendar $calendar, RecurrenceOptionsService $recurrenceOptions)
    {
        return response()->json([
            'months' => $calendar->months ?? [],
            'current' => [
                'year' => $calendar->currentDate('year'),
                'month' => $calendar->currentDate('month'),
                'day' => $calendar->currentDate('date'),
            ],
            'recurring' => $recurrenceOptions->forApi($calendar),
        ]);
    }

    public function today(Campaign $campaign, Calendar $calendar)
    {
        $this->authorize('update', $calendar->entity);

        if ($date = request()->get('date')) {
            $calendar->update(['date' => $date]);
        }

        return redirect()->back()->with('success', __('calendars.edit.today'));
    }
}
