<?php

namespace App\Http\Resources;

use App\Models\MapMarker;

class MapMarkerResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var MapMarker $model */
        $model = $this->resource;

        return $this->entity([
            'map_id' => $model->map_id,
            'name' => $model->name,
            'entity_id' => $model->entity_id,
            'longitude' => $model->longitude,
            'latitude' => $model->latitude,
            'colour' => $model->colour,
            'font_colour' => $model->font_colour,
            'shape_id' => $model->shape_id,
            'size_id' => $model->size_id,
            'pin_size' => $model->pin_size,
            'icon' => $model->icon,
            'custom_icon' => $model->custom_icon,
            'custom_shape' => $model->custom_shape,
            'is_draggable' => (bool) $model->is_draggable,
            'is_popupless' => (bool) $model->is_popupless,
            'opacity' => $model->opacity,
            'circle_radius' => $model->circle_radius,
            'polygon_style' => $model->polygon_style,
            'visibility_id' => $model->visibility_id,
            'css' => $model->css,
        ]);
    }
}
