<?php

namespace App\Http\Resources;

use App\Models\AttributeTemplate;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeTemplateResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var AttributeTemplate $model */
        $model = $this->resource;

        return $this->entity([
            'entity_type_id' => $model->entity_type_id,
            'attribute_template' => $model->attribute_template_id,
        ]);
    }
}
