<?php

namespace App\Http\Resources;

use App\Models\FamilyTree;
use Illuminate\Http\Request;

class FamilyTreeResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var FamilyTree $model */
        $model = $this->resource;

        return $model->config ?? [];
    }
}
