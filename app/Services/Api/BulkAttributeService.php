<?php

namespace App\Services\Api;

use App\Models\Attribute;
use App\Services\Attributes\BaseAttributesService;
use App\Services\Attributes\RandomService;
use App\Traits\EntityAware;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Stevebauman\Purify\Facades\Purify;

class BulkAttributeService extends BaseAttributesService
{
    use EntityAware;

    protected array $existingNames = [];

    protected RandomService $randomService;

    public function __construct(RandomService $randomService)
    {
        $this->randomService = $randomService;
    }

    /**
     * Add form attributes to an entity
     *
     * @throws Exception
     */
    public function save(array $attributes, $deleteOld = true): self
    {
        // First, let's get all the stuff for this entity
        $existingAttributes = $this->entity->attributes()
            // Need with() for saving to meilisearch
            ->with('entity')
            ->get();

        foreach ($existingAttributes as $att) {
            $this->existing[$att->id] = $att;
            $this->existingNames[$att->id] = $att->name;
        }

        $this->purifyConfig();

        foreach ($attributes as $attribute) {
            $this->saveAttribute($attribute);
        }

        if ($deleteOld) {
            // Remaining existing attributes have been deleted
            foreach ($this->existing as $id => $attribute) {
                $this->touched = true;
                $attribute->delete();
            }
        }

        return $this;
    }

    protected function saveAttribute(array $attributeArray): self
    {
        try {
            // If they set an id we check if its a valid one, then fetch that attribute to edit it
            if (isset($attributeArray['id'])) {
                /** @var Attribute $attribute */
                $attribute = Arr::get($this->existing, $attributeArray['id']);
                // If its an existing attribute we remove it from the existing names list.
                if (! empty($attribute)) {
                    unset($this->existingNames[$attribute->id]);
                }
            }

            /** @var Attribute $attr */
            $attr = new Attribute($attributeArray);

            if (empty($attr->name) || in_array($attr->name, $this->existingNames)) {
                return $this;
            }
            $name = Purify::config($this->purifyConfig)->clean($attr->name);
            $value = Purify::config($this->purifyConfig)->clean($attr->value ?? '');
            // Save empty strings as null
            $value = $value === '' ? null : $value;

            if (! isset($attribute)) {
                $attribute = new Attribute;
            }

            // If the linked entity isn't an attribute template, we might be dealing with a random value
            if (! $this->entity->isAttributeTemplate()) {
                [$attr->type_id, $value] =
                    $this->randomService->randomAttribute($attr->type_id, $value);
            }

            $attribute->name = $name;
            $attribute->setValue($value);
            $attribute->is_private = $attr->is_private ?? 0;
            $attribute->is_pinned = $attr->is_pinned ?? 0;
            $attribute->type_id = $attr->type_id;

            // Some fields can only be defined on creation
            if (! $attribute->exists) {
                $attribute->entity_id = $this->entity->id;
                $attribute->is_hidden = $attr->is_hidden ?? 0;
                $attribute->origin_attribute_id = $attr->source_id ?? null;
            }
            $attribute->default_order = $this->order;
            if ($attribute->isDirty() || ! $attribute->exists) {
                $this->touched = true;
            }
            $attribute->save();

            // Remove it from the list of existing ids, so that it doesn't get deleted
            unset($this->existing[$attribute->id]);
            // We add the new name to the list
            $this->existingNames[$attribute->id] = $attribute->name;

            $this->order++;
        } catch (Exception $e) {
            if (app()->isProduction()) {
                Log::error($e->getMessage());
            } else {
                throw $e;
            }
        }

        return $this;
    }
}
