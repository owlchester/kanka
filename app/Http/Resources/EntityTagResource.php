<?php

namespace App\Http\Resources;

use App\Models\EntityTag;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityTagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityTag $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'entity_id' => $model->entity_id,
            'tag_id' => $model->tag_id,
        ];
    }
}
