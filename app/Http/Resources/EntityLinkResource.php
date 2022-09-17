<?php

namespace App\Http\Resources;

use App\Models\EntityLink;

class EntityLinkResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityLink $model */
        $model = $this->resource;
        return $this->entity([
            'name' => $model->name,
            'visibility_id' => $model->visibility_id,
            'url' => $model->url,
            'icon' => $model->icon,
            'position' => $model->position,
        ]);
    }
}
