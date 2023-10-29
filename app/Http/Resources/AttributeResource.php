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
            'type' => $this->typeMapper($attribute),
            'default_order' => $attribute->default_order,
            'is_star' => (bool) $attribute->isPinned(),
            'is_pinned' => (bool) $attribute->isPinned(),
            'api_key' => $attribute->api_key,
            'type_id' => $attribute->type_id,
        ]);
    }

    protected function typeMapper(Attribute $attribute): string|null
    {
        return match ($attribute->type_id) {
            Attribute::TYPE_TEXT_ID => Attribute::TYPE_TEXT,
            Attribute::TYPE_CHECKBOX_ID => Attribute::TYPE_CHECKBOX,
            Attribute::TYPE_SECTION_ID => Attribute::TYPE_SECTION,
            Attribute::TYPE_RANDOM_ID => Attribute::TYPE_RANDOM,
            Attribute::TYPE_NUMBER_ID => Attribute::TYPE_NUMBER,
            Attribute::TYPE_LIST_ID => Attribute::TYPE_LIST,
            default => Attribute::TYPE_TEXT,
        };
    }
}
