<?php

namespace App\Http\Resources;

use App\Models\Event;

class EventResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Event $model */
        $model = $this->resource;
        return $this->entity([
            'event_id' => $model->event_id,
            'date' => $model->date,
            'calendar_id' => $model->entity->calendarDate?->calendar_id,
            'calendar_year' => $model->entity->calendarDate?->year,
            'calendar_month' => $model->entity->calendarDate?->month,
            'calendar_day' => $model->entity->calendarDate?->day,
        ]);
    }
}
