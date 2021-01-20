<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return $this->entity([
            'type' => $this->type,
            'date' => $this->date,
            'is_completed' => (bool) $this->is_completed,
            'quest_id' => $this->quest_id,
            'character_id' => $this->character_id,
            'calendar_id' => $this->calendar_id,
            'calendar_year' => $this->calendar_year,
            'calendar_month' => $this->calendar_month,
            'calendar_day' => $this->calendar_day,
            'characters' => $this->characters->count(),
            'locations' => $this->locations->count(),
            'items' => $this->items->count(),
            'organisations' => $this->organisations->count(),
        ]);
    }
}
