<?php

namespace App\Http\Resources;

use App\Models\EntityAlias;

class EntityAliasResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityAlias $model */
        $model = $this->resource;
        return $this->entity([
            'name' => $model->name,
            'visibility_id' => $model->visibility_id,
        ]);
    }
}
