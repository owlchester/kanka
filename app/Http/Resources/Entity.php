<?php

namespace App\Http\Resources;

use App\Facades\Avatar;
use Illuminate\Support\Facades\Route;

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

        if ($model->isMissingChild()) {
            return ['error' => 'KA7: Entity #' . $model->id . ' missing child.'];
        }

        $url = $model->url();
        $apiViewUrl = 'campaigns.' . $model->entityType->pluralCode() . '.show';

        return [
            'id' => $model->id,
            'child_id' => $model->hasChild() ? $model->id : null,
            'child_type' => $model->hasChild() ? $model->entityType->code : null,
            'name' => $model->name,
            'image' => Avatar::entity($model)->original(),
            'image_thumb' => Avatar::entity($model)->size(40)->thumbnail(),
            'has_custom_image' => ! empty($model->image_path) && ! empty($model->image),

            'type' => $model->type,
            'type_id' => $model->type_id,
            'entity_type' => $model->entityType->code,
            'tooltip' => $model->tooltip,
            'url' => $model->url(),
            'is_attributes_private' => $model->is_attributes_private,

            'is_private' => (bool) $model->is_private,

            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
            'updated_by' => $model->updated_by,

            'urls' => [
                'view' => $url,
                'api' => Route::has($apiViewUrl) ? route($apiViewUrl, [$model->campaign_id, $model->entity_id]) : null,
            ],
        ];
    }
}
