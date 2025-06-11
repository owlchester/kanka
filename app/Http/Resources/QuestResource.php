<?php

namespace App\Http\Resources;

use App\Models\Quest;

class QuestResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Quest $model */
        $model = $this->resource;

        return $this->entity([
            'date' => $model->date,
            'is_completed' => $model->isCompleted(),
            'quest_id' => $model->quest_id,
            'instigator_id' => $model->instigator_id,
            'location_id' => $model->location_id,
            'calendar_id' => $model->entity->calendarDate?->calendar_id,
            'calendar_year' => $model->entity->calendarDate?->year,
            'calendar_month' => $model->entity->calendarDate?->month,
            'calendar_day' => $model->entity->calendarDate?->day,
            'calendar_reminder_length' => $model->entity->calendarDate?->length,
            'elements_count' => $model->elements->count(),
            'elements' => QuestElementResource::collection($model->elements),
        ]);
    }
}
