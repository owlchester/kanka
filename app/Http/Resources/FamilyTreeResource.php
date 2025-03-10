<?php

namespace App\Http\Resources;

use App\Models\FamilyTree;

class FamilyTreeResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var FamilyTree $model */
        $model = $this->resource;

        return $model->config ?? [];
    }
}
