<?php

namespace App\Http\Resources;

use App\Models\EntityAlias;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
