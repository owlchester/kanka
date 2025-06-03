<?php

namespace App\Http\Resources;

use App\Models\Bookmark;

class BookmarkResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Bookmark $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'entity_id' => $model->entity_id,
            'filters' => $model->filters,
            'icon' => $model->icon,
            'is_private' => $model->is_private,
            'is_active' => $model->is_active,
            'menu' => $model->menu,
            'random_entity_type' => $model->random_entity_type,
            'entity_type_id' => $model->entity_type_id,
            'tab' => $model->tab,
            'target' => $model->target,
            'dashboard_id' => $model->dashboard_id,
            'parent' => $model->parent,
            'css' => $model->css,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'created_by' => $model->created_by,
            'updated_by' => $model->updated_by,
            'options' => $model->options,
        ];
    }
}
