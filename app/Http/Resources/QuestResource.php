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
            'type' => $model->type,
            'date' => $model->date,
            'is_completed' => $model->isCompleted(),
            'quest_id' => $model->quest_id,
            'character_id' => $model->character_id,
            'calendar_id' => $model->calendar_id,
            'calendar_year' => $model->calendar_year,
            'calendar_month' => $model->calendar_month,
            'calendar_day' => $model->calendar_day,
            'elements_count' => $model->elements->count(),
            'elements' => QuestElementResource::collection($model->elements)
        ]);
    }
}
