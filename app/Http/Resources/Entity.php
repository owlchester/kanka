<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'id' => $this->child->id,
            'entity_id' => $this->id,
            'name' => $this->name,
            'image' => $this->child->getImageUrl(true),
            'type' => $this->type,
            'tooltip' => $this->tooltip(),
            'url' => $this->url(),

            'is_private' => (bool) $this->child->is_private,

            'created_at' => $this->child->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->child->updated_at,
            'updated_by' => $this->updated_by,

            /*
             *
                    'id' => $model->id,
                    'fullname' => $model->name,
                    'image' => !empty($model->child->image) ? '<span class="entity-image-mention" style="background-image: url(\'' . $model->child->getImageUrl(true) . '\');"></span> ' : '',
                    'name' => $model->name,
                    'type' => trans('entities.' . $model->type),
                    'tooltip' => $model->tooltip(),
                    'url' => route($model->pluralType() . '.show', $model->entity_id)
             */
        ];
    }
}
