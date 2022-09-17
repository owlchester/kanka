<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'type' => $model->type,
            'event_id' => $model->event_id,
            'date' => $model->date,
        ]);
    }
}
