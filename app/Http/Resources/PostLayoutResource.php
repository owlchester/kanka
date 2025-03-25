<?php

namespace App\Http\Resources;

use App\Models\PostLayout;
use Illuminate\Http\Resources\Json\JsonResource;

class PostLayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var PostLayout $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'code' => $model->code,
            'entity_type_id' => $model->entity_type_id,
            'config' => $model->config,
        ];
    }
}
