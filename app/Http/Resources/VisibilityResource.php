<?php

namespace App\Http\Resources;

use App\Models\Visibility;
use Illuminate\Http\Resources\Json\JsonResource;

class VisibilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Visibility $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'code' => $model->code,
        ];
    }
}
