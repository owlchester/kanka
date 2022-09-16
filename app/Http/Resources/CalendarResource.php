<?php

namespace App\Http\Resources;

use App\Models\Calendar;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Calendar $calendar */
        $calendar = $this->resource;

        return $this->entity([
            'type' => $calendar->type,
            'date' => $calendar->date,
            'parameters' => $calendar->parameters,
            'months' => json_decode($calendar->months),
            'weekdays' => json_decode($calendar->weekdays),
            'years' => json_decode($calendar->years),
            'seasons' => json_decode($calendar->seasons),
            'moons' => json_decode($calendar->moons),
            'start_offset' => $calendar->start_offset, // X year is a leap year
            'suffix' => $calendar->suffix,
            'has_leap_year' => $calendar->has_leap_year,
            'leap_year_amount' => $calendar->leap_year_amount, // Add X number of days
            'leap_year_month' => $calendar->leap_year_month, // At the end of month X
            'leap_year_offset' => $calendar->leap_year_offset, // every X years
            'leap_year_start' => $calendar->leap_year_start, // X year is a leap year
        ]);
    }
}
