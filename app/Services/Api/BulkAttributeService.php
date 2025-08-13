<?php

namespace App\Services\Api;

use App\Models\Attribute;
use App\Models\MiscModel;
use App\Services\Attributes\RandomService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Stevebauman\Purify\Facades\Purify;

class BulkAttributeService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected MiscModel $new;

    protected Attribute $attribute;

    protected array $purifyConfig;

    protected array $existing = [];

    protected array $existingNames = [];

    protected int $order = 0;

    protected bool $touched = false;

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
    public function save(array $attributes, $deleteOld = false): self
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

            if (! isset($attribute) || empty($attribute)) {
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
            $attribute->type_id = $attr->type_id; // @phpstan-ignore-line

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

    /**
     * When we're done updating the attributes, if anything was changed, we need to "touch" the entity to have a log and
     * updated timestamp.
     */
    public function touch(): self
    {
        if (! $this->touched) {
            return $this;
        }
        $this->entity->touch();

        return $this;
    }

    /**
     * Prepare a custom HTML purifying config for attributes. We remove all custom fields that are added to purify.php
     * and in PurifySetupProvider.
     */
    protected function purifyConfig(): self
    {
        $purifyConfig = config('purify.configs.default');
        $purifyConfig['HTML.Allowed'] = preg_replace('`,a\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,iframe\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,summary\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,table\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,details\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,figure\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,figcaption\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);

        $this->purifyConfig = $purifyConfig;

        return $this;
    }
}
