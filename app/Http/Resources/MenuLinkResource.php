<?php

namespace App\Http\Resources;

use App\Models\MenuLink;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuLinkResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var MenuLink $model */
        $model = $this->resource;
        return [
            'id' => $model->id,
            'name' => $model->name,
            'entity_id' => $model->entity_id,
            'filters' => $model->filters,
            'icon' => $model->icon,
            'is_private' => $model->is_private,
            'menu' => $model->menu,
            'random_entity_type' => $model->random_entity_type,
            'type' => $model->type,
            'tab' => $model->tab,
            'target' => $model->target,
            'dashboard_id' => $model->dashboard_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
