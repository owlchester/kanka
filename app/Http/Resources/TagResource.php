<?php

namespace App\Http\Resources;

use App\Models\Tag;

class TagResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Tag $model */
        $model = $this->resource;

        return $this->entity([
            'tag_id' => $model->tag_id,
            'colour' => $model->colour,
            'icon' => $model->icon,
            'icon_in_label' => (bool) $model->icon_in_label,
            'entities' => $model->entities()->distinct()->pluck('entities.id')->toArray(),
            'is_auto_applied' => (bool) $model->is_auto_applied,
            'is_hidden' => (bool) $model->is_hidden,
        ]);
    }
}
