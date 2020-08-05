<?php

namespace App\Http\Resources;

use App\Models\Timeline;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Timeline $model */
        $model = $this->resource;
        return $this->entity([
            'type' => $model->type,
            'calendar_id' => $model->calendar_id,
            'eras' => TimelineEraResource::collection($model->eras),
        ]);
    }
}
