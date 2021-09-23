<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityChild extends JsonResource
{
    use ApiSync;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function entity(array $prepared = [])
    {
        $merged = [
            'id' => $this->id,

            'is_private' => (bool) $this->is_private,
            'entity_id' => $this->entity->id,

            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ];

        $final = array_merge($prepared, $merged);
        ksort($final);
        return $final;
    }
}
