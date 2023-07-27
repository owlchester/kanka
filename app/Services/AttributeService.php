<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Services\Attributes\RandomService;
use App\Services\Attributes\TemplateService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kanka\Dnd5eMonster\Template;
use Stevebauman\Purify\Facades\Purify;

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
    protected bool $touched = false;

    protected RandomService $randomService;
    protected TemplateService $templateService;

    public function __construct(RandomService $randomService, TemplateService $templateService)
    {
        $this->randomService = $randomService;
        $this->templateService = $templateService;
    }

    /**
     * Apply a template to an entity
     * @param Entity $entity
     * @param int|string $templateId
     * @return string|bool
     */
    public function apply(Entity $entity, mixed $templateId)
    {
        return $this->templateService->entity($entity)->apply($templateId);
    }

    /**
     * Deprecated as of 1.30
     * Get a community template base on its name to render properly
     * @param string $template
     * @return bool|Template
     */
    public function communityTemplate(string $template)
    {
        /** @var array $templates */
        $templates = config('attribute-templates.templates');
        if (Arr::exists($templates, $template)) {
            /** @var Template $template */
            return new $templates[$template]();
        }
        return false;
    }

    /**
     * Add form attributes to an entity
     * @param array $request
     * @return int
     * @throws \Exception
     */
    public function save($request)
    {
        // First, let's get all the stuff for this entity
        $existingAttributes = $this->entity->attributes()->where('is_hidden', '0')->get();

        //Dont load hidden attributes for deletion, unless deleting all.
        if (empty($request) || request()->filled('delete-all-attributes')) {
            $existingAttributes = $this->entity->attributes()->get();
        }
        foreach ($existingAttributes as $att) {
            $this->existing[$att->id] = $att;
        }

        $this->names = Arr::get($request, 'attr_name', []);
        $this->values = Arr::get($request, 'attr_value', []);
        $this->types = Arr::get($request, 'attr_type', []);
        $this->privates = Arr::get($request, 'attr_is_private', []);
        $this->stars = Arr::get($request, 'attr_is_pinned', []);
        $templateId = Arr::get($request, 'template_id', null);

        $this->purifyConfig();

        foreach ($this->names as $id => $name) {
            $this->saveAttribute($id, $name);
        }

        // Remaining existing have been deleted
        foreach ($this->existing as $id => $attribute) {
            $this->touched = true;
            $attribute->delete();
        }

        // If a template id was provided, try and add it to the new entity.
        if (!empty($templateId)) {
            $this->apply($this->entity, $templateId);
        }

        if ($this->touched) {
            $this->entity->touchSilently();
            $this->entity->child->touchSilently();
        }

        return $this->order;
    }

    protected function saveAttribute($id, $name): self
    {
        // Skip empties, which are probably the templates, but still allow an attribute called '0'
        if (empty($name) || $name == '$TMP_ID') {
            if ($name !== '0') {
                return $this;
            }
        }

        $name = Purify::clean($name, $this->purifyConfig);
        $value = Purify::clean($this->values[$id] ?? '', $this->purifyConfig);
        $typeID = $this->types[$id] ?? '';
        $isPrivate = !empty($this->privates[$id]);
        $isStar = !empty($this->stars[$id]);

        // Save empty strings as null
        $value = $value === '' ? null : $value;

        // Edit an existing attribute
        if (!empty($this->existing[$id])) {
            /** @var \App\Models\Attribute $attribute */
            $attribute = $this->existing[$id];
            $attribute->type_id = $typeID;
            $attribute->name = $name;
            $attribute->setValue($value);
            $attribute->is_private = $isPrivate;
            $attribute->is_pinned = $isStar;
            $attribute->default_order = $this->order;
            if ($attribute->isDirty()) {
                $this->touched = true;
            }
            $attribute->save();

            // Remove it from the list of existing ids so it doesn't get deleted
            unset($this->existing[$id]);
        } else {
            // Special case if the attribute is a random
            if ($this->entity->typeId() != config('entities.ids.attribute_template')) {
                list($typeID, $value) = $this->randomService->randomAttribute($typeID, $value);
            }

            $attribute = new Attribute([
                'entity_id' => $this->entity->id,
                'type_id' => $typeID,
                'name' => $name,
                'is_private' => $isPrivate,
                'is_pinned' => $isStar,
                'default_order' => $this->order,
            ]);
            $attribute->setValue($value);
            $attribute->save();
            $this->touched = true;
        }
        $this->order++;

        return $this;
    }

    /**
     * @param bool $privateAttributes
     * @return $this
     */
    public function updateVisibility(bool $privateAttributes): self
    {
        // Only admins can update this value
        if (!auth()->user()->isAdmin()) {
            return $this;
        }
        $this->entity->is_attributes_private = $privateAttributes;
        $this->entity->saveQuietly();
        return $this;
    }

    /**
     * Apply attribute templates to a new entity
     * @param Entity $entity
     * @param int $order
     * @return int
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
     * @param Campaign $campaign
     * @return array
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
     * @return array
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
        /*$key = __('attributes/templates.list.kanka');
        foreach (config('attribute-templates.templates') as $code => $class) {
            $template = new $class();
            $templates[$key][$code] = $template->name();
        }*/

        // If the campaign isn't boosted, or the marketplace isn't enable, end here
        if (!$this->campaign->boosted() || !config('marketplace.enabled')) {
            return $templates;
        }

        // Marketplace campaigns
        $key = __('attributes/templates.list.marketplace');
        // @phpstan-ignore-next-line
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
     * @return self
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

    /**
     * Map an attribute type from its string representation to an ID (as saved in the DB)
     * @param string|null $type the string type of attribute to be converted to an int
     * @return int
     */
    protected function mapAttributeTypeToID(string $type = null): int
    {
        if (empty($type) || $type === 'attribute') {
            return Attribute::TYPE_STANDARD_ID;
        }

        $mapping = [
            Attribute::TYPE_TEXT => Attribute::TYPE_TEXT_ID,
            Attribute::TYPE_CHECKBOX => Attribute::TYPE_CHECKBOX_ID,
            Attribute::TYPE_SECTION => Attribute::TYPE_SECTION_ID,
            'block' => Attribute::TYPE_SECTION_ID,
            Attribute::TYPE_RANDOM => Attribute::TYPE_RANDOM_ID,
            Attribute::TYPE_NUMBER => Attribute::TYPE_NUMBER_ID,
            Attribute::TYPE_LIST => Attribute::TYPE_LIST_ID
        ];

        if (isset($mapping[$type])) {
            return $mapping[$type];
        }
        dd('missing mapping for ' . $type);
    }
}
