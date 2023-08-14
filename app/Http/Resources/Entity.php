<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

        $url = $model->url();
        $apiViewUrl = 'campaigns.' . $model->pluralType() . '.show';

        return [
            'id' => $model->child->id,
            'entity_id' => $model->id,
            'name' => $model->name,
            'image' => $model->child->thumbnail(0),
            'image_thumb' => $model->child->thumbnail(),
            'has_custom_image' => !empty($model->child->image),

            // @phpstan-ignore-next-line
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

            'urls' => [
                'view' => $url,
                'api' => Route::has($apiViewUrl) ? route($apiViewUrl, [$model->campaign_id, $model->entity_id]) : null,
            ]
        ];
    }
}
