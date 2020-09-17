<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->entity([
            'type' => $this->type,
            'height' => $this->height,
            'width' => $this->width,
            'map_id' => $this->map_id,
            'grid' => $this->grid,
            'min_zoom' => $this->minZoom(),
            'max_zoom' => $this->maxZoom(),
            'initial_zoom' => $this->initialZoom(),
            'center_x' => $this->center_x,
            'center_y' => $this->center_y,
            'layers' => MapLayerResource::collection($this->layers),
            'groups' => MapGroupResource::collection($this->layers),
        ]);
    }
}
