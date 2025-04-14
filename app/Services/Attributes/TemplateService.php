<?php

namespace App\Services\Attributes;

use App\Enums\AttributeType;
use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kanka\Dnd5eMonster\Template;

class TemplateService
{
    use CampaignAware;
    use EntityAware;

    protected RandomService $randomService;

    protected array $loadedTemplates = [];

    protected array $loadedPlugins = [];

    protected string $templateName;

    public function __construct(RandomService $randomService)
    {
        $this->randomService = $randomService;
    }

    public function templateName(): string
    {
        return $this->templateName;
    }

    public function apply(mixed $templateId): bool
    {
        $templateIdInt = (int) $templateId;
        if (Str::isUuid($templateId)) {
            return $this->applyMarketplaceTemplate($templateId);
        } elseif (is_int($templateIdInt) && ! empty($templateIdInt)) {
            $attributeTemplate = $this->getAttributeTemplate($templateId);
            $attributeTemplate->apply($this->entity);
            $this->templateName = $attributeTemplate->name;

            return true;
        }

        return false;
    }

    /**
     * Apply a marketplace character sheet on an entity based on its uuid. This is called in the BULK interface
     *
     * @todo: move to a separate service
     */
    public function applyMarketplaceTemplate(string $uuid): bool
    {
        $campaign = $this->entity->campaign;
        if (! $campaign->boosted()) {
            return false;
        }

        $plugin = $this->getMarketplacePlugin($uuid, $campaign);
        if (empty($plugin)) {
            return false;
        }

        $order = $this->entity->attributes()->count();
        $existing = array_values($this->entity->attributes()->pluck('name')->toArray());
        foreach ($plugin->version->attributes as $attribute) {
            // If the config is simply a name, we default to a small varchar
            if (! is_array($attribute)) {
                continue;
            }

            // Don't re-create existing attributes.
            $name = Arr::get($attribute, 'name', 'unknown');
            if (in_array($name, $existing)) {
                continue;
            }
            $type = Arr::get($attribute, 'type', '');
            $type = $this->mapAttributeTypeToID($type);
            $value = Arr::get($attribute, 'value', '');

            [$type, $value] = $this->randomService->randomAttribute($type, $value);

            $order++;

            Attribute::create([
                'entity_id' => $this->entity->id,
                'name' => $name,
                'value' => $value,
                'default_order' => $order,
                'is_private' => false,
                'type_id' => $type,
                'is_pinned' => false,
                'is_hidden' => Arr::get($attribute, 'is_hidden', false),
            ]);
        }

        // Layout attribute for rendering
        $layout = '_layout';
        if (! in_array($layout, $existing)) {
            $order++;

            Attribute::create([
                'entity_id' => $this->entity->id,
                'name' => '_layout',
                'value' => $plugin->version->uuid,
                'default_order' => $order,
                'is_private' => false,
                'is_pinned' => false,
                'type_id' => AttributeType::Standard,
            ]);
        }

        $this->entity->touch();
        $this->templateName = $plugin->plugin->name;

        return true;
    }

    /**
     * Get a character sheet marketplace plugin model from the db based on its uuid
     */
    public function marketplaceTemplate(string $uuid): ?CampaignPlugin
    {
        if (! $this->campaign->boosted() || ! config('marketplace.enabled')) {
            return null;
        }

        if (! Str::isUuid($uuid)) {
            return null;
        }

        /** @var ?CampaignPlugin $plugin */
        $plugin = CampaignPlugin::templates($this->campaign)
            ->select('campaign_plugins.*')
            ->leftJoin('plugin_versions as pv', 'pv.plugin_id', 'campaign_plugins.plugin_id')
            ->where('pv.uuid', $uuid)
            ->has('plugin')
            ->first();

        // If the plugin is published, we're good. Otherwise, it's
        if (empty($plugin) || ! $plugin->renderable()) {
            return null;
        }

        return $plugin;
    }

    /**
     * Get an attribute template model from the campaign based on its ID
     */
    protected function getAttributeTemplate(int $templateId): AttributeTemplate
    {
        if (isset($this->loadedTemplates[$templateId])) {
            return $this->loadedTemplates[$templateId];
        }
        /** @var AttributeTemplate $attributeTemplate */
        $attributeTemplate = AttributeTemplate::findOrFail($templateId);

        return $this->loadedTemplates[$templateId] = $attributeTemplate;
    }

    /**
     * Get a marketplace plugin's model based on its UUID
     *
     * @return CampaignPlugin|null
     */
    protected function getMarketplacePlugin(string $pluginUuid, Campaign $campaign)
    {
        if (isset($this->loadedPlugins[$pluginUuid])) {
            return $this->loadedPlugins[$pluginUuid];
        }

        return $this->loadedPlugins[$pluginUuid] = CampaignPlugin::templates($campaign)
            ->select('campaign_plugins.*')
            // ->leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('p.uuid', $pluginUuid)
            ->first();
    }

    /**
     * Map an attribute type from its string representation to an ID (as saved in the DB)
     *
     * @param  string|null  $type  the string type of attribute to be converted to an int
     */
    protected function mapAttributeTypeToID(?string $type = null): AttributeType
    {
        if (empty($type) || $type === 'attribute') {
            return AttributeType::Standard;
        }

        $mapping = [
            'text' => AttributeType::Block,
            'checkbox' => AttributeType::Checkbox,
            'section' => AttributeType::Section,
            'block' => AttributeType::Section,
            'random' => AttributeType::Random,
            'number' => AttributeType::Number,
            'list' => AttributeType::List,
        ];

        if (isset($mapping[$type])) {
            return $mapping[$type];
        }
        dd('missing mapping for ' . $type);
    }

    /**
     * Deprecated as of 1.30
     * Get a community template base on its name to render properly
     *
     * @return bool|Template
     */
    public function communityTemplate(string $template)
    {
        $templates = config('attribute-templates.templates');
        if (Arr::exists($templates, $template)) {
            /** @var Template $template */
            return new $templates[$template];
        }

        return false;
    }

    public function api(string|int $template): array
    {
        $templateIdInt = (int) $template;
        if (Str::isUuid($template)) {
            return $this->loadMarketplaceTemplate($template);
        } elseif (is_int($templateIdInt) && ! empty($templateIdInt)) {
            return $this->loadCampaignTemplate($template);
        }

        return [];
    }

    protected function loadMarketplaceTemplate(string $template): array
    {
        $plugin = $this->getMarketplacePlugin($template, $this->campaign);
        if (empty($plugin)) {
            return [];
        }

        $attributes = [];
        foreach ($plugin->version->attributes as $attribute) {
            // If the config is simply a name, we default to a small varchar
            if (! is_array($attribute)) {
                continue;
            }

            // Don't re-create existing attributes.
            $name = Arr::get($attribute, 'name', 'unknown');
            $type = Arr::get($attribute, 'type', '');
            $type = $this->mapAttributeTypeToID($type);
            $value = Arr::get($attribute, 'value', '');

            [$type, $value] = $this->randomService->randomAttribute($type, $value);

            $attributes[] = [
                'name' => $name,
                'value' => $value,
                'is_private' => false,
                'is_pinned' => false,
                'is_hidden' => (bool) Arr::get($attribute, 'is_hidden', false),
                'is_checked' => false,
                'is_deleted' => false,

                'is_checkbox' => $type === AttributeType::Checkbox,
                'is_multiline' => $type === AttributeType::Block,
                'is_section' => $type === AttributeType::Section,
                'is_number' => $type === AttributeType::Number,
            ];
        }

        // Layout attribute for rendering
        $attributes[] = [
            'name' => '_layout',
            'value' => $plugin->version->uuid,
            'is_private' => false,
            'is_pinned' => false,
            'is_hidden' => false,
            'is_checked' => false,
            'is_deleted' => false,
        ];

        return $attributes;
    }

    protected function loadCampaignTemplate(int $templateId): array
    {
        $template = AttributeTemplate::findOrFail($templateId);
        $attributes = [];

        /** @var Attribute $attribute */
        foreach ($template->entity->attributes()->orderBy('default_order', 'ASC')->get() as $attribute) {
            [$type, $value] = $this->randomService->randomAttribute($attribute->type_id, $attribute->value);
            $attribute->type_id = $type;

            $attributes[] = [
                'name' => $attribute->name,
                'value' => $value,
                'is_private' => (bool) $attribute->is_private,
                'is_pinned' => $attribute->isPinned(),
                'is_hidden' => false,
                'is_checked' => false,
                'is_deleted' => false,
                'source_id' => $attribute->id,

                'is_checkbox' => $attribute->isCheckbox(),
                'is_multiline' => $attribute->isText(),
                'is_random' => $attribute->isRandom(),
                'is_section' => $attribute->isSection(),
                'is_number' => $attribute->isNumber(),
            ];
        }

        return $attributes;
    }
}
