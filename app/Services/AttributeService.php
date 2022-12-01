<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kanka\Dnd5eMonster\Template;
use Stevebauman\Purify\Facades\Purify;

class AttributeService
{
    protected array $loadedTemplates = [];
    protected array $loadedPlugins = [];
    protected Campaign $campaign;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * Apply a template to an entity
     * @param Entity $entity
     * @param int|string $templateId
     * @return string|bool
     */
    public function apply(Entity $entity, $templateId)
    {
        $templateIdInt = (int) $templateId;
        if (Str::isUuid($templateId)) {
            return $this->applyMarketplaceTemplate($templateId, $entity);
        } elseif (is_integer($templateIdInt) && !empty($templateIdInt)) {
            /** @var AttributeTemplate $template */
            $template = $this->getAttributeTemplate($templateId);
            $template->apply($entity);
            return $template->name;
        }
        return false;
    }

    /**
     * Deprecated as of 1.30
     * Get a community template base on its name to render properly
     * @param string $template
     * @return bool|Template
     */
    public function communityTemplate($template)
    {
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
     * @param Entity $entity
     * @return int
     * @throws \Exception
     */
    public function saveEntity($request, Entity $entity)
    {
        // First, let's get all the stuff for this entity
        $existing = [];
        $existingAttributes = $entity->attributes()->where('is_hidden', '0')->get();

        //Dont load hidden attributes for deletion, unless deleting all.
        if (empty($request) || request()->filled('delete-all-attributes')) {
            $existingAttributes = $entity->attributes()->get();
        }

        foreach ($existingAttributes as $att) {
            $existing[$att->id] = $att;
        }

        $order = 0;
        $names = Arr::get($request, 'attr_name', []);
        $values = Arr::get($request, 'attr_value', []);
        $types = Arr::get($request, 'attr_type', []);
        $privates = Arr::get($request, 'attr_is_private', []);
        $stars = Arr::get($request, 'attr_is_star', []);
        $templateId = Arr::get($request, 'template_id', null);
        $touch = false;

        $purifyConfig = $this->purifyConfig();

        foreach ($names as $id => $name) {
            // Skip empties, which are probably the templates, but still allow an attribute called '0'
            if (empty($name) || $name == '$TMP_ID') {
                if ($name !== '0') {
                    continue;
                }
            }

            $name = Purify::clean($name, $purifyConfig);
            $value = Purify::clean($values[$id] ?? '', $purifyConfig);
            $typeID = $types[$id] ?? '';
            $isPrivate = !empty($privates[$id]);
            $isStar = !empty($stars[$id]);

            // Save empty strings as null
            $value = $value === '' ? null : $value;

            if (!empty($existing[$id])) {
                // Edit an existing attribute
                /** @var \App\Models\Attribute $attribute */
                $attribute = $existing[$id];
                $attribute->type_id = $typeID;
                $attribute->name = $name;
                $attribute->setValue($value);
                $attribute->is_private = $isPrivate;
                $attribute->is_star = $isStar;
                $attribute->default_order = $order;
                if ($attribute->isDirty()) {
                    $touch = true;
                }
                $attribute->save();

                // Remove it from the list of existing ids so it doesn't get deleted
                unset($existing[$id]);
            } else {
                // Special case if the attribute is a random
                if ($entity->typeId() != config('entities.ids.attribute_template')) {
                    list ($typeID, $value) = $this->randomAttribute($typeID, $value);
                }

                $attribute = new Attribute([
                    'entity_id' => $entity->id,
                    'type_id' => $typeID,
                    'name' => $name,
                    'is_private' => $isPrivate,
                    'is_star' => $isStar,
                    'default_order' => $order,
                ]);
                $attribute->setValue($value);
                $attribute->save();
                $touch = true;
            }
            $order++;
        }

        // Remaining existing have been deleted
        foreach ($existing as $id => $attribute) {
            $touch = true;
            $attribute->delete();
        }

        // If a template id was provided, try and add it to the new entity.
        if (!empty($templateId)) {
            $this->apply($entity, $templateId);
        }

        if ($touch) {
            $entity->touchSilently();
            $entity->child->touchSilently();
        }

        return $order;
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
        $templates = AttributeTemplate::where(['entity_type_id' => $typeId])->get();
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
        $campaignTemplates = AttributeTemplate::orderBy('name', 'ASC')->pluck('name', 'id');
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
     * Apply a marketplace character sheet on an entity based on its uuid.
     * @todo: move to a separate service
     * @param string $uuid
     * @param Entity $entity
     * @return false|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function applyMarketplaceTemplate(string $uuid, Entity $entity)
    {
        $campaign = $entity->campaign;
        if (!$campaign->boosted()) {
            return false;
        }

        $plugin = $this->getMarketplacePlugin($uuid, $campaign);
        if (empty($plugin)) {
            return false;
        }

        $order = $entity->attributes()->count();
        $existing = array_values($entity->attributes()->pluck('name')->toArray());
        foreach ($plugin->version->attributes as $attribute) {
            // If the config is simply a name, we default to a small varchar
            if (!is_array($attribute)) {
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

            list ($type, $value) = $this->randomAttribute($type, $value);

            $order++;

            Attribute::create([
                'entity_id' => $entity->id,
                'name' => $name,
                'value' => $value,
                'default_order' => $order,
                'is_private' => false,
                'type_id' => $type,
                'is_star' => false,
                'is_hidden' => $attribute['is_hidden']
            ]);
        }

        // Layout attribute for rendering
        $layout = '_layout';
        if (!in_array($layout, $existing)) {
            $order++;

            Attribute::create([
                'entity_id' => $entity->id,
                'name' => '_layout',
                'value' => $plugin->version->uuid,
                'default_order' => $order,
                'is_private' => false,
                'is_star' => false,
                'type_id' => Attribute::TYPE_STANDARD_ID,
            ]);
        }

        return $plugin->plugin->name;
    }

    /**
     * Get a character sheet marketplace plugin model from the db based on its uuid
     * @param string $uuid
     * @param Campaign $campaign
     * @return CampaignPlugin|null
     */
    public function marketplaceTemplate($uuid, Campaign $campaign)
    {
        if (!$campaign->boosted() || !config('marketplace.enabled')) {
            return null;
        }

        if (!Str::isUuid($uuid)) {
            return null;
        }

        /** @var CampaignPlugin|null $plugin */
        // @phpstan-ignore-next-line
        $plugin = CampaignPlugin::templates($campaign)
            ->select('campaign_plugins.*')
            ->leftJoin('plugin_versions as pv', 'pv.plugin_id', 'campaign_plugins.plugin_id')
            ->where('pv.uuid', $uuid)
            ->has('plugin')
            ->first();

        // If the plugin is published, we're good. Otherwise, it's
        if (empty($plugin) || !$plugin->renderable()) {
            return null;
        }

        return $plugin;
    }

    /**
     * Get an attribute template model from the campaign based on its ID
     * @param int $templateId
     * @return AttributeTemplate
     */
    protected function getAttributeTemplate(int $templateId)
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
     * @param string $pluginUuid
     * @param Campaign $campaign
     * @return CampaignPlugin|null
     */
    protected function getMarketplacePlugin(string $pluginUuid, Campaign $campaign)
    {
        if (isset($this->loadedPlugins[$pluginUuid])) {
            return $this->loadedPlugins[$pluginUuid];
        }
        return $this->loadedPlugins[$pluginUuid] = CampaignPlugin::templates($campaign)
            ->select('campaign_plugins.*')
            //->leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('p.uuid', $pluginUuid)
            ->first();
    }

    /**
     * Rewrite an attribute if it's a random value
     * @param int $type
     * @param string $value
     * @return array[string, string]
     */
    public function randomAttribute(int $type, $value): array
    {
        // Special case if the attribute is a random
        if ($type != Attribute::TYPE_RANDOM_ID) {
            return [$type, $value];
        }
        // Remap the type to a number attribute
        $type = Attribute::TYPE_STANDARD_ID;

        try {
            // List of strings separated by commas
            if (Str::contains($value, ',')) {
                $values = explode(',', $value);
                $validValues = [];
                foreach ($values as $val) {
                    $val = trim($val);
                    if (!empty($val)) {
                        $validValues[] = $val;
                    }
                }

                if (empty($validValues)) {
                    return [$type, $value];
                } elseif (count($validValues) == 1) {
                    return [$type, Arr::first($validValues)];
                }

                return [$type, Arr::random($validValues)];
            } elseif (Str::contains($value, '-')) {
                // Numerical value
                $values = explode('-', $value);
                if (count($values) !== 2) {
                    return [$type, $value];
                }

                $min = (int) trim($values[0]);
                $max = (int) trim($values[1]);

                return [$type, mt_rand($min, $max)];
            }
        } catch (\Exception $e) {
            // Something went wrong, let's assume the random value is badly formatted
            return [$type, $value];
        }

        return [$type, $value];
    }

    /**
     * Prepare a custom HTML purifying config for attributes. We remove all custom fields that are added to purify.php
     * and in PurifySetupProvider.
     * @return array
     */
    protected function purifyConfig(): array
    {
        $purifyConfig = config('purify.settings');
        $purifyConfig['HTML.Allowed'] = preg_replace('`,a\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,iframe\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,summary\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,table\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,details\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,figure\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,figcaption\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        return $purifyConfig;
    }

    /**
     * Map an attribute type from it's string representation to an ID (as saved in the DB)
     * @param string|null $type the string type of attribute to be converted to an int
     * @return int
     */
    protected function mapAttributeTypeToID(string $type = null): int
    {
        if (empty($type) || $type === 'attribute') {
            return Attribute::TYPE_STANDARD_ID;
        }

        if ($type === Attribute::TYPE_TEXT) {
            return Attribute::TYPE_TEXT_ID;
        } elseif ($type === Attribute::TYPE_CHECKBOX) {
            return Attribute::TYPE_CHECKBOX_ID;
        } elseif ($type === Attribute::TYPE_SECTION) {
            return Attribute::TYPE_SECTION_ID;
        } elseif ($type === Attribute::TYPE_RANDOM) {
            return Attribute::TYPE_RANDOM_ID;
        } elseif ($type === Attribute::TYPE_NUMBER) {
            return Attribute::TYPE_NUMBER_ID;
        } elseif ($type === Attribute::TYPE_LIST) {
            return Attribute::TYPE_LIST_ID;
        } elseif ($type === 'block') {
            return Attribute::TYPE_SECTION_ID;
        }
        dd('missing mapping for ' . $type);
    }
}
