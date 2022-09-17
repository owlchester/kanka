<?php

namespace App\Http\Resources;

class Entity extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Entity $model */
        $model = $this->resource;

        if (empty($model->child)) {
            return ['error' => 'KA7: Entity #' . $model->id . ' missing child.'];
        }
        return [
            'id' => $model->child->id,
            'entity_id' => $model->id,
            'name' => $model->name,
            'image' => $model->child->getImageUrl(0),
            'image_thumb' => $model->child->getImageUrl(40),
            'has_custom_image' => !empty($model->child->image),

            'type' => $model->type(),
            'type_id' => $model->type_id,
            'tooltip' => $model->tooltip,
            'url' => $model->url(),
            'is_attributes_private' => $model->is_attributes_private,

            'is_private' => (bool) $model->child->is_private,

            'created_at' => $model->child->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->child->updated_at,
            'updated_by' => $model->updated_by,
        ];
    }
}
