<?php

namespace App\Http\Resources;

use App\Models\Family;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Family $model */
        $model = $this->resource;
        return $this->entity([
            'type' => $model->type,
            'family_id' => $model->family_id,
            'members' => $model->members()->pluck('character_id')->toArray()
        ]);
    }
}
