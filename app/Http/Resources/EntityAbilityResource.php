<?php

namespace App\Http\Resources;

use App\Models\EntityAbility;

class EntityAbilityResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityAbility $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'visibility_id' => $model->visibility_id,
            'charges' => $model->charges,
            'ability_id' => $model->ability_id,
            'position' => $model->position,
            'note' => $model->note,
            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
            'updated_by' => $model->updated_by,
        ];
    }
}
