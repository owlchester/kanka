<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityEventResource extends EntityChild
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
            'calendar_id' => $this->calendar_id,
            'date' => $this->date(),
            'day' => $this->day,
            'month' => $this->month,
            'year' => $this->year,
            'length' => $this->length,
            'comment' => $this->comment,
            'is_recurring' => (bool) $this->is_recurring,
            'recurring_until' => $this->recurring_until,
            'recurring_periodicity' => $this->recurring_periodicity,
            'colour' => $this->colour,
        ]);
    }
}
