<?php

namespace App\Http\Resources;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Family $model */
        $model = $this->resource;

        return $this->entity([
            'family_id' => $model->family_id,
            'is_extinct' => $model->isExtinct(),
            'members' => $model->members()->pluck('character_id')->toArray(),
        ]);
    }
}
