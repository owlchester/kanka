<?php

namespace App\Http\Resources;

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
        return $this->entity([
            'type' => $this->type,
            'date' => $this->date,
            'parameters' => $this->parameters,
            'months' => json_decode($this->months),
            'weekdays' => json_decode($this->weekdays),
            'years' => json_decode($this->years),
            'seasons' => json_decode($this->seasons),
            'moons' => json_decode($this->moons),
            'start_offset' => $this->start_offset, // X year is a leap year
            'suffix' => $this->suffix,
            'has_leap_year' => $this->has_leap_year,
            'leap_year_amount' => $this->leap_year_amount, // Add X number of days
            'leap_year_month' => $this->leap_year_month, // At the end of month X
            'leap_year_offset' => $this->leap_year_offset, // every X years
            'leap_year_start' => $this->leap_year_start, // X year is a leap year
        ]);
    }
}
