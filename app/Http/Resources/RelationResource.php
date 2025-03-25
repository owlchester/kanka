<?php

namespace App\Http\Resources;

use App\Models\Relation;
use Illuminate\Http\Resources\Json\JsonResource;

class RelationResource extends JsonResource
{
    use ApiSync;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Relation $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'owner_id' => $model->owner_id,
            'target_id' => $model->target_id,
            'relation' => $model->relation,
            'attitude' => $model->attitude,
            'colour' => $model->colour,
            // 'is_private' => (bool) $this->is_private,
            'visibility_id' => $model->visibility_id,
            'is_star' => (bool) $model->isPinned(),
            'is_pinned' => (bool) $model->isPinned(),
            'mirror_id' => $model->mirror_id,
            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
        ];
    }
}
