<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityEvent extends EntityChild
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
            'calendar_id' => $this->name,
            'date' => $this->date,
            'length' => $this->length,
            'comment' => $this->comment,
            'is_recurring' => (bool) $this->is_recurring,
            'recurring_until' => $this->recurring_until,
        ]);
    }
}
