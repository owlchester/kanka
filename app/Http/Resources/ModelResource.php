<?php

namespace App\Http\Resources;

use App\Models\Item;
use App\Models\MiscModel;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    use ApiSync;

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function entity(array $prepared = [])
    {
        /** @var MiscModel|\App\Models\Entity|Item $model */
        $model = $this->resource;
        $merged = [
            'id' => $model->id,
            'is_private' => (bool) $model->is_private,

            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
            'updated_by' => $model->updated_by,
        ];

        $final = array_merge($prepared, $merged);
        ksort($final);

        return $final;
    }
}
