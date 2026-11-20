<?php

namespace App\Http\Resources;

use App\Services\Images\Img;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityDefaultThumbnailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'entity_type' => $resource['type'],
            'url' => Img::for($resource['path'])->url(),
        ];
    }
}
