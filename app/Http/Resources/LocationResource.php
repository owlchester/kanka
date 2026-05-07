<?php

namespace App\Http\Resources;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Location $model */
        $model = $this->resource;

        return $this->entity([
            'title' => $model->title,
        ]);
    }
}
