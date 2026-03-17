<?php

namespace App\Http\Resources;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Tag $model */
        $model = $this->resource;

        return $this->entity([
            'colour' => $model->colour,
            'icon' => $model->icon,
            'entities' => $model->entities()->distinct()->pluck('entities.id')->toArray(),
            'is_auto_applied' => (bool) $model->is_auto_applied,
            'is_hidden' => (bool) $model->is_hidden,
        ]);
    }
}
