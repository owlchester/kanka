<?php

namespace App\Http\Resources;

use App\Models\Timeline;

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
            'timeline_id' => $model->timeline_id,
            'eras' => TimelineEraResource::collection($model->eras()->with('elements')->get()),
            'revert_order' => $model->revert_order,
        ]);
    }
}
