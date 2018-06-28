<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\Entity;

class AttributeService
{
    public function saveMany(Entity $entity, $data)
    {
        // Get the existing ones to build an array of ids
        $existing = [];
        foreach ($entity->attributes()->get() as $att) {
            $existing[$att->id] = $att;
        }

        $order = 0;
        foreach ($data['name'] as $id => $name) {
            $value = $data['value'][$id];
            $isPrivate = !empty($data['is_private'][$id]);

            if (empty($name)) {
                continue;
            }

            if (!empty($existing[$id])) {
                // Edit an existing attribute
                /** @var \App\Models\Attribute $attribute */
                $attribute = $existing[$id];
                $attribute->name = $name;
                $attribute->value = $value;
                $attribute->is_private = $isPrivate;
                $attribute->default_order = $order;
                $attribute->save();

                // Remove it from the list of existing ids so it doesn't get deleted
                unset($existing[$id]);
            } else {
                $attribute = Attribute::create([
                    'entity_id' => $entity->id,
                    'name' => $name,
                    'value' => $value,
                    'is_private' => $isPrivate,
                    'default_order' => $order,
                ]);
            }

            $order++;
        }

        // Remaining existing have been deleted
        foreach ($existing as $id => $attribute) {
            $attribute->delete();
        }
    }
}
