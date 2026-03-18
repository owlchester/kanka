<?php

namespace App\Http\Resources;

use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Timeline $model */
        $model = $this->resource;

        return $this->entity([
            'eras' => TimelineEraResource::collection($model->eras()->with('elements')->get()),
            'revert_order' => $model->revert_order,
        ]);
    }
}
