<?php

namespace App\Services;

use App\Enums\AttributeType;
use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Services\Attributes\RandomService;
use App\Services\Attributes\TemplateService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;
use Exception;

class AttributeService
{
    use CampaignAware;
    use EntityAware;

    protected array $purifyConfig;

    protected array $existing = [];
    protected int $order = 0;

    protected array $names;
    protected array $values;
    protected array $types;
    protected array $privates;
    protected array $stars;
    protected array $hidden;
    protected bool $touched = false;

    protected RandomService $randomService;
    protected TemplateService $templateService;

    protected string $templateName;

    public function __construct(RandomService $randomService, TemplateService $templateService)
    {
        $this->randomService = $randomService;
        $this->templateService = $templateService;
    }

    /**
     * Apply a template to an entity
     * @param int|string $templateId
     */
    public function apply(Entity $entity, mixed $templateId): void
    {
        $this->templateService
            ->entity($entity)
            ->apply($templateId);
    }

    /**
     * Add form attributes to an entity
     * @throws Exception
     */
    public function save(array $attributes): self
    {
        // First, let's get all the stuff for this entity
        $existingAttributes = $this->entity->attributes()
            // Need with() for saving to meilisearch
            ->with('entity')
            ->get();
        foreach ($existingAttributes as $att) {
            $this->existing[$att->id] = $att;
        }

        $this->purifyConfig();


        foreach ($attributes as $attribute) {
            $this->saveAttribute($attribute);
        }

        // Remaining existing have been deleted
        foreach ($this->existing as $id => $attribute) {
            $this->touched = true;
            $attribute->delete();
        }

        return $this;
    }

    /**
     * When we're done updating the attributes, if anything was changed, we need to "touch" the entity to have a log and
     * updated timestamp.
     */
    public function touch(): self
    {
        if (!$this->touched) {
            return $this;
        }
        $this->entity->touch();
        if ($this->entity->hasChild()) {
            $this->entity->child->touchSilently();
        }
        return $this;
    }

    protected function saveAttribute(string $attributeJson): self
    {
        try {
            /** @var Attribute $attr */
            $attr = json_decode($attributeJson);
            if (empty($attr->name)) {
                return $this;
            }
            $name = Purify::clean($attr->name, $this->purifyConfig);
            $value = Purify::clean($attr->value ?? '', $this->purifyConfig);
            // Save empty strings as null
            $value = $value === '' ? null : $value;

            /** @var Attribute $attribute */
            $attribute = Arr::get($this->existing, $attr->id);
            if (empty($attribute)) {
                $attribute = new Attribute();
            }

            // If the linked entity isn't an attribute template, we might be dealing with a random value
            if (!$this->entity->isAttributeTemplate()) {
                list($attr->type, $value) =
                    $this->randomService->randomAttribute(AttributeType::from($attr->type), $value);
            }

            $attribute->name = $name;
            $attribute->setValue($value);
            $attribute->is_private = $attr->is_private;
            $attribute->is_pinned = $attr->is_pinned;
            $attribute->type_id = $attr->type; // @phpstan-ignore-line
            // Some fields can only be defined on creation
            if (!$attribute->exists) {
                $attribute->entity_id = $this->entity->id;
                $attribute->is_hidden = $attr->is_hidden;
                $attribute->origin_attribute_id = $attr->source_id ?? null;
            }
            $attribute->default_order = $this->order;
            if ($attribute->isDirty() || !$attribute->exists) {
                $this->touched = true;
            }
            $attribute->save();

            // Remove it from the list of existing ids, so that it doesn't get deleted
            unset($this->existing[$attr->id]);
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
     * @return $this
     */
    public function updateVisibility(bool $privateAttributes): self
    {
        // Only admins can update this value
        if (!auth()->user()->isAdmin()) {
            return $this;
        }
        $this->entity->is_attributes_private = $privateAttributes ? 1 : 0;
        // If the setting was changed, the entity is dirty and will need be be touched later
        if ($this->entity->isDirty('is_attributes_private')) {
            $this->touched = true;
        }
        return $this;
    }

    /**
     * Apply attribute templates to a new entity
     */
    public function applyEntityTemplates(Entity $entity, int $order = 0): int
    {
        $typeId = $entity->typeId();
        $templates = AttributeTemplate::has('entity')->where(['entity_type_id' => $typeId])->get();
        /** @var AttributeTemplate $template */
        foreach ($templates as $template) {
            $order = $template->apply($entity, $order);
        }
        return $order;
    }

    /**
     * Deprecated?
     */
    public function templates(Campaign $campaign): array
    {
        $templates = [];

        foreach (config('attribute-templates.templates') as $code => $class) {
            $template = new $class();
            $templates[$code] = $template->name();
        }
        // Get templates from the plugins
        if ($campaign->boosted() && config('marketplace.enabled')) {
            foreach (CampaignPlugin::templates($campaign)->get() as $plugin) {
                if (empty($plugin->plugin)) {
                    continue;
                }
                $templates[$plugin->plugin->uuid] = __('campaigns/plugins.templates.name', [
                    'name' => $plugin->name,
                    'user' => $plugin->plugin->author()
                ]);
            }
        }

        return $templates;
    }

    /**
     * Build a list of templates:
     * - First display attribute templates from the campaign
     * - Then display character sheets from the marketplace installed on the campaign
     */
    public function templateList(): array
    {
        $templates = [];

        // Campaign templates
        $campaignTemplates = AttributeTemplate::has('entity')
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');
        $key = __('attributes/templates.list.campaign');
        foreach ($campaignTemplates as $id => $name) {
            $templates[$key][$id] = $name;
        }

        // Kanka templates - deprecated as of 1.30
        //        $key = __('attributes/templates.list.kanka');
        //        foreach (config('attribute-templates.templates') as $code => $class) {
        //            $template = new $class();
        //            $templates[$key][$code] = $template->name();
        //        }

        // If the campaign isn't boosted, or the marketplace isn't enable, end here
        if (!$this->campaign->boosted() || !config('marketplace.enabled')) {
            return $templates;
        }

        // Marketplace campaigns
        $key = __('attributes/templates.list.marketplace');
        foreach (CampaignPlugin::templates($this->campaign)->with(['plugin', 'plugin.user'])->get() as $plugin) {
            if (empty($plugin->plugin)) {
                continue;
            }
            $templates[$key][$plugin->plugin->uuid] = __('campaigns/plugins.templates.name', [
                'name' => $plugin->name,
                'user' => $plugin->plugin->author()
            ]);
        }

        return $templates;
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

    public function replaceMentions(int $sourceId): self
    {
        $source = Entity::findOrFail($sourceId);

        $sourceAttributes = [];
        foreach ($source->attributes as $attribute) {
            $sourceAttributes[Str::slug($attribute->name)] = $attribute->id;
        }
        $searchAttributes = $replaceAttributes = [];
        foreach ($this->entity->attributes as $attribute) {
            $slug = Str::slug($attribute->name);
            if (!isset($sourceAttributes[$slug])) {
                continue;
            }
            $searchAttributes[] = '{attribute:' . $sourceAttributes[$slug] . '}';
            $replaceAttributes[] = '{attribute:' . $attribute->id . '}';
        }
        if ($this->entity->hasEntry()) {
            $entry = Str::replace($searchAttributes, $replaceAttributes, $this->entity->entry);
            $this->entity->update(['entry' => $entry]);
        }
        foreach ($this->entity->posts as $post) {
            $post->entry = Str::replace($searchAttributes, $replaceAttributes, $post->entry);
            $post->updateQuietly();
        }
        return $this;
    }
}
