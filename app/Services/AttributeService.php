<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Models\Plugin;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kanka\Dnd5eMonster\Template;

class AttributeService
{
    /** @var array */
    protected $loadedAttributes = [];

    protected $loadedTemplates = [];
    protected $loadedPlugins = [];

    protected $loadedEntity = null;

    /**
     * @param Entity $entity
     * @return string
     */
    public function parse(Attribute $attribute): string
    {
        if (!Str::contains($attribute->value, ['{', '}'])) {
            return (string) $attribute->value;
        }

        if ($this->loadedEntity === null || $this->loadedEntity->id != $attribute->entity_id) {
            $this->loadedEntity = $attribute->entity;
        }

        try {
            return $this->entityAttributes()->get($attribute->name, $attribute->value);

        } catch(\Exception $e) {
            return $attribute->value;
        }
    }

    /**
     * Load all the entity attributes and pre-calculate the values
     * @return array|\Illuminate\Support\Collection
     */
    protected function entityAttributes()
    {
        if (isset($this->loadedAttributes[$this->loadedEntity->id])) {
            return $this->loadedAttributes[$this->loadedEntity->id];
        }

        $attributes = $this->loadedEntity->attributes()->pluck('value', 'name');

        // Parse all attributes to calculate the values
        foreach ($attributes as $id => $attribute) {

            try {
                // Replace {} with entity attributes
                $value = preg_replace_callback('`\{(.*?)\}`i', function ($matches) use ($attributes) {
                    $text = $matches[1];
                    if ($attributes->has($text)) {
                        return $attributes->get($text);
                    }
                    if ($text == 'name') {
                        return (string) $this->loadedEntity->name;
                    }
                    return 0;
                }, $attribute);

                $calculator = new StringCalc();
                $attributes[$id] = $calculator->calculate($value);
            } catch(\Exception $e) {
                $attributes[$id] = $value;
            }
        }

        return $this->loadedAttributes[$this->loadedEntity->id] = $attributes;
    }

    /**
     * @param Entity $entity
     * @param $data
     * @throws \Exception
     */
    public function saveMany(Entity $entity, $data)
    {
        // Get the existing ones to build an array of ids
        $existing = [];
        foreach ($entity->attributes()->get() as $att) {
            $existing[$att->id] = $att;
        }

        $order = 0;
        $names = Arr::get($data, 'attr_name', []);
        $values = Arr::get($data, 'attr_value', []);
        $types = Arr::get($data, 'attr_type', []);
        $privates = Arr::get($data, 'attr_is_private', []);
        $stars = Arr::get($data, 'attr_is_star', []);

        foreach ($names as $id => $name) {
            // Skip empties, which are probably the templates
            if (empty($name)) {
                continue;
            }

            $value = isset($values[$id]) ? $values[$id] : null ;
            $type = isset($types[$id]) ? $types[$id] : null;
            $isPrivate = !empty($privates[$id]);
            $isStar = !empty($stars[$id]);

            if (!empty($existing[$id])) {
                // Edit an existing attribute
                /** @var \App\Models\Attribute $attribute */
                $attribute = $existing[$id];
                $attribute->type = $type;
                $attribute->name = $name;
                $attribute->value = $value;
                $attribute->is_private = $isPrivate;
                $attribute->is_star = $isStar;
                $attribute->default_order = $order;
                $attribute->save();

                // Remove it from the list of existing ids so it doesn't get deleted
                unset($existing[$id]);
            } else {
                // Special case if the attribute is a random
                list ($type, $value) = $this->randomAttribute($type, $value);

                $attribute = Attribute::create([
                    'entity_id' => $entity->id,
                    'type' => $type,
                    'name' => $name,
                    'value' => $value,
                    'is_private' => $isPrivate,
                    'is_star' => $isStar,
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

    /**
     * @param Entity $entity
     * @param $request
     * @return string
     */
    public function apply(Entity $entity, $request)
    {
        // Are we using a local template?
        $templateId = Arr::get($request, 'template_id');
        $communityTemplate = Arr::get($request, 'template');

        if ($templateId) {
            /** @var AttributeTemplate $template */
            $template = $this->getAttributeTemplate($templateId);
            $template->apply($entity);
            return $template->name;
        } elseif ($communityTemplate) {
            $templates = config('attribute-templates.templates');
            if (Arr::exists($templates, $communityTemplate)) {
                /** @var Template $template */
                $template = new $templates[$communityTemplate];
                $order = $entity->attributes()->count();

                $existing = array_values($entity->attributes()->pluck('name')->toArray());
                foreach ($template->attributes() as $name => $attribute) {
                    // If the config is simply a name, we default to a small varchar
                    if (!is_array($attribute)) {
                        $name = $attribute;
                        $attribute = [];
                    }

                    // Don't re-create existing attributes.
                    if (in_array($name, $existing)) {
                        continue;
                    }

                    $type = Arr::get($attribute, 'type', null);
                    $private = Arr::get($attribute, 'is_private', false);
                    $star = Arr::get($attribute, 'is_star', false);

                    // Value is based on the translation. This can get confusing
                    $translationKey = $template->alias() . '::template.values.' . $name;
                    $value = __($translationKey);
                    if ($value == $translationKey) {
                        $value = '';
                    }

                    list($type, $value) = $this->randomAttribute($type, $value);
                    $order++;

                    Attribute::create([
                        'entity_id' => $entity->id,
                        'name' => $name,
                        'value' => $value,
                        'default_order' => $order,
                        'is_private' => $private,
                        'type' => $type,
                        'is_star' => $star
                    ]);
                }

                // Layout attribute for rendering
                $layout = '_layout';
                if (!in_array($layout, $existing)) {
                    $order++;

                    Attribute::create([
                        'entity_id' => $entity->id,
                        'name' => '_layout',
                        'value' => $communityTemplate,
                        'default_order' => $order,
                        'is_private' => false,
                        'is_star' => false,
                        'type' => null,
                    ]);
                }


                return $template->name();
            }

            // We might be getting a plugin
            return $this->applyMarketplaceTemplate((int) $communityTemplate, $entity);
        }
        return false;
    }

    /**
     * @param $template
     * @return bool
     */
    public function communityTemplate($template)
    {
        $templates = config('attribute-templates.templates');
        if (Arr::exists($templates, $template)) {
            /** @var Template $template */
            return new $templates[$template];
        }
        return false;
    }

    /**
     * Add form attributes to an entity
     * @param $request
     * @param Entity $entity
     * @return int
     * @throws \Exception
     */
    public function saveEntity($request, Entity $entity)
    {
        // First, let's get all the stuff for this entity
        $existing = [];
        foreach ($entity->attributes()->get() as $att) {
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

        foreach ($names as $id => $name) {
            // Skip empties, which are probably the templates, but still allow an attribute called '0'
            if (empty($name) || $name == '$TMP_ID') {
                if ($name !== '0') {
                    continue;
                }
            }

            $value = $values[$id] ?? '';
            $type = $types[$id];
            $isPrivate = !empty($privates[$id]);
            $isStar = !empty($stars[$id]);

            if (!empty($existing[$id])) {
                // Edit an existing attribute
                /** @var \App\Models\Attribute $attribute */
                $attribute = $existing[$id];
                $attribute->type = $type;
                $attribute->name = $name;
                $attribute->value = $value;
                $attribute->is_private = (int) $isPrivate;
                $attribute->is_star = (int) $isStar;
                $attribute->default_order = $order;
                if ($attribute->isDirty()) {
                    $touch = true;
                }
                $attribute->save();

                // Remove it from the list of existing ids so it doesn't get deleted
                unset($existing[$id]);
            } else {
                // Special case if the attribute is a random
                list ($type, $value) = $this->randomAttribute($type, $value);

                Attribute::create([
                    'entity_id' => $entity->id,
                    'type' => $type,
                    'name' => $name,
                    'value' => $value,
                    'is_private' => $isPrivate,
                    'is_star' => $isStar,
                    'default_order' => $order,
                ]);
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
            /** @var AttributeTemplate $template */
            $template = AttributeTemplate::findOrFail($templateId);
            $order = $template->apply($entity, $order);
        }

        if ($touch) {
            $entity->touchSilently();
            $entity->child->touchSilently();
        }

        return $order;
    }

    /**
     * Apply an entity's templates on creation
     * @param Entity $entity
     * @param int $order
     * @return int
     */
    public function applyEntityTemplates(Entity $entity, $order = 0)
    {
        $typeId = $entity->typeId();
        /** @var AttributeTemplate $template */
        $templates = AttributeTemplate::where(['entity_type_id' => $typeId])->get();
        foreach ($templates as $template) {
            $order = $template->apply($entity, $order);
        }
        return $order;
    }

    public function templates(Campaign $campaign): array
    {
        $templates = [];

        foreach (config('attribute-templates.templates') as $code => $class) {
            $template = new $class;
            $templates[$code] = $template->name();
        }
        // Get templates from the plugins
        if ($campaign->boosted()) {
            foreach(CampaignPlugin::templates($campaign)->get() as $plugin) {
                $templates[$plugin->plugin->uuid] = __('campaigns/plugins.templates.name', [
                    'name' => $plugin->name,
                    'user' => $plugin->plugin->author()
                ]);
            }
        }

        return $templates;
    }

    /**
     * @param int $id
     * @param Entity $entity
     * @return false|\Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public function applyMarketplaceTemplate(int $id, Entity $entity)
    {
        $campaign = $entity->campaign;
        if (!$campaign->boosted()) {
            return false;
        }

        $plugin = $this->getMarketplacePlugin($id, $campaign);
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

            $type = Arr::get($attribute, 'type', null);
            $value = Arr::get($attribute, 'value', '');


            list ($type, $value) = $this->randomAttribute($type, $value);

            $order++;

            Attribute::create([
                'entity_id' => $entity->id,
                'name' => $name,
                'value' => $value,
                'default_order' => $order,
                'is_private' => false,
                'type' => $type != 'attribute' ? $type : '',
                'is_star' => false
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
                'type' => null,
            ]);
        }

        return $plugin->plugin->name;
    }

    /**
     * @param $uuid
     * @param Campaign $campaign
     * @return CampaignPlugin|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function marketplaceTemplate($uuid, Campaign $campaign)
    {
        if (!$campaign->boosted()) {
            return null;
        }

        if (!Str::isUuid($uuid)) {
            return null;
        }

        $plugin = CampaignPlugin::templates($campaign)
            ->select('campaign_plugins.*')
            ->leftJoin('plugin_versions as pv', 'pv.plugin_id', 'campaign_plugins.plugin_id')
            ->where('pv.uuid', $uuid)
            ->first();

        return $plugin;
    }

    /**
     * @param int $templateId
     * @return AttributeTemplate
     */
    protected function getAttributeTemplate(int $templateId)
    {
        if (isset($this->loadedTemplates[$templateId])) {
            return $this->loadedTemplates[$templateId];
        }
        return $this->loadedTemplates[$templateId] = AttributeTemplate::findOrFail($templateId);
    }

    /**
     * @param int $pluginId
     * @param int $campaign
     * @return CampaignPlugin
     */
    protected function getMarketplacePlugin(int $pluginId, $campaign)
    {
        if (isset($this->loadedPlugins[$pluginId])) {
            return $this->loadedPlugins[$pluginId];
        }
        return $this->loadedPlugins[$pluginId] = CampaignPlugin::templates($campaign)
            ->select('campaign_plugins.*')
            //->leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('p.uuid', $pluginId)
            ->first();
    }

    /**
     * Rewrite an attribute if it's a random value
     * @param string $type
     * @param string $value
     * @return array[string, string]
     */
    public function randomAttribute($type, $value)
    {
        // Special case if the attribute is a random
        if ($type != Attribute::TYPE_RANDOM || request()->is('*/attribute_templates/*')) {
            return [$type, $value];
        }
        // Remap the type to a standard attribute
        $type = '';

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

                $min = trim($values[0]);
                $max = trim($values[1]);

                return [$type, mt_rand($min, $max)];
            }
        } catch(\Exception $e) {
            // Something went wrong, let's assume the random value is badly formatted
            return [$type, $value];
        }

        return [$type, $value];
    }
}
