<?php

namespace App\Http\Resources;

use App\Models\MiscModel;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
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
        /** @var MiscModel $model */
        $model = $this->resource;
        $merged = [
            'id' => $model->id,
            'is_private' => (bool) $model->is_private,

            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
            'updated_by' => $model->updated_by,
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
