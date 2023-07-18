<?php

namespace App\Http\Resources;

use App\Facades\Api;
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
        $lang = request()->header('kanka-locale', auth()->user()->locale ?? 'en');
        $url = Str::replaceFirst('campaign/', $lang . '/campaign/', $url);

        // On the API subdomain? Fix urls
        if (Api::isSubdomain()) {
            $url = Api::fixUrl($url);
        }

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
                'api' => route('campaigns.' . $model->pluralType() . '.show', [$model->campaign_id, $model->entity_id]),
            ]
        ];
    }
}
