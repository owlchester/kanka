<?php

namespace App\Http\Resources;

use App\Models\Attribute;

class AttributeResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Attribute $attribute */
        $attribute = $this->resource;

        return $this->entity([
            'name' => $attribute->name,
            'value' => $attribute->value,
            'parsed' => $attribute->mappedValue(),
            'type' => $attribute->type,
            'default_order' => $attribute->default_order,
            'is_star' => (bool) $attribute->isPinned(),
            'is_pinned' => (bool) $attribute->isPinned(),
            'api_key' => $attribute->api_key
        ]);
    }
}
