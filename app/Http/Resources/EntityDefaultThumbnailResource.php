<?php

namespace App\Http\Resources;

use App\Facades\Img;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityDefaultThumbnailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'entity_type' => $resource['type'],
            'url' => Img::url($resource['path']),
        ];
    }
}
