<?php

namespace App\Http\Resources\Attributes;

use App\Models\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveAttributeResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Attribute $attribute */
        $attribute = $this->resource;

        $formatted = [
            'id' => $attribute->id,
            'name' => $attribute->mappedName(),
            'name_raw' => $attribute->name,
            'value' => $attribute->isCheckbox() ? (bool) $attribute->value : $attribute->mappedValue(),
            'value_raw' => $attribute->value,
            'type_id' => $attribute->type_id,
            'is_section' => $attribute->isSection(),
            'is_number' => $attribute->isNumber(),
            'is_multiline' => $attribute->isText(),
            'is_checkbox' => $attribute->isCheckbox(),
            'is_random' => $attribute->isRandom(),
            'is_private' => (bool) $attribute->is_private,
            'is_pinned' => $attribute->isPinned(),
            'is_hidden' => (bool) $attribute->is_hidden,
        ];

        if ($attribute->isList()) {
            $formatted['values'] = $attribute->listRange();
        }

        // Routes
        $formatted['apis'] = [
            'update' => [
                'method' => 'POST',
                'url' => route('entities.attributes.live-api.update', [$attribute->entity->campaign, $attribute->entity, $attribute]),
            ],
            'delete' => [
                'method' => 'POST',
                'url' => route('entities.attributes.live-api.delete', [$attribute->entity->campaign, $attribute->entity, $attribute]),
            ],
        ];

        return $formatted;
    }
}
