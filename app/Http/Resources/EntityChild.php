<?php

namespace App\Http\Resources;

use App\Models\Attribute;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityChild extends JsonResource
{
    use ApiSync;

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function entity(array $prepared = [])
    {
        /** @var MiscModel $model */
        $model = $this->resource;
        $merged = [
            'id' => $model->id,

            'is_private' => (bool) $model->is_private,
            'entity_id' => $model->entity->id,

            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
            'updated_by' => $model->updated_by,
        ];

        $final = array_merge($prepared, $merged);
        ksort($final);

        return $final;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function onEntity(array $prepared = [])
    {
        /** @var Model|Attribute|mixed $model */
        $model = $this->resource;
        $merged = [
            'id' => $model->id,

            'is_private' => (bool) $model->is_private,
            'entity_id' => $model->entity_id,

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
