<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
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

            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ];

        // Foreign elements
        $attributes = $this->getAttributes();
        if (method_exists($this, 'tags')) {
            $merged['tags'] = TagResource::collection($this->tags);
        }
        if (array_key_exists('location_id', $attributes)) {
            $merged['location_id'] = $this->location_id;
        }
        if (array_key_exists('character_id', $attributes)) {
            $merged['character_id'] = $this->character_id;
        }

        $final = array_merge($prepared, $merged);
        ksort($final);
        return $final;
    }
}
