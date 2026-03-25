<?php

namespace App\Http\Resources;

use App\Models\CalendarEra;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarEraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CalendarEra $era */
        $era = $this->resource;

        return [
            'id' => $era->id,
            'calendar_id' => $era->calendar_id,
            'name' => $era->name,
            'description' => $era->description,
            'colour' => $era->colour,
            'visibility_id' => $era->visibility_id,
            'start_day' => $era->start_day,
            'start_month' => $era->start_month,
            'start_year' => $era->start_year,
            'end_day' => $era->end_day,
            'end_month' => $era->end_month,
            'end_year' => $era->end_year,
            'show_era_dates' => $era->show_era_dates,
            'created_at' => $era->created_at,
            'updated_at' => $era->updated_at,
        ];
    }
}
