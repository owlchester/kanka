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
            'id' => $model->pivot->id, // @phpstan-ignore-line
            'tag_id' => $model->id,
        ];
    }
}
