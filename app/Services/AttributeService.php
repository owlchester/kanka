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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Kanka\Dnd5eMonster\Template;
use Exception;
use Stevebauman\Purify\Facades\Purify;

class AttributeService
{
    /** @var array */
    protected $loadedAttributes = [];

    protected $loadedTemplates = [];
    protected $loadedPlugins = [];

    protected $loadedEntity = null;

    /** @var Campaign */
    protected $campaign;

    /** @var null|Collection */
    protected $calculatedAttributes = null;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param Entity $entity
     * @param string $field
     * @return string
     */
    public function parse(Attribute $attribute, string $field = 'value'): string
    {
        if (!$this->validField($attribute->$field)) {
            return (string) $attribute->$field;
        }

        if ($this->loadedEntity === null || $this->loadedEntity->id != $attribute->entity_id) {
            $this->loadedEntity = $attribute->entity;
        }

        try {
            $calculated = $this->entityAttributes()->get($attribute->name);
            return (string) $calculated['final'];

        } catch(\Exception $e) {
            //throw $e;
            return (string) $attribute->$field;
        }
    }

    /**
     * Replace references in an attribute name with attribute values for ranges
     * @param Attribute $attribute
     * @param string $field
     * @return string
     * @throws \ChrisKonnertz\StringCalc\Exceptions\ContainerException
     * @throws \ChrisKonnertz\StringCalc\Exceptions\NotFoundException
     */
    public function map(Attribute $attribute, string $field = 'name'): string
    {
        if (!$this->validField($attribute->$field)) {
            return (string) $attribute->$field;
        }

        if ($this->loadedEntity === null || $this->loadedEntity->id != $attribute->entity_id) {
            $this->loadedEntity = $attribute->entity;
        }

        try {
            // Prepare all the attributes and calculates them
            $this->entityAttributes();

            $data = [
                'name' => $attribute->name,
                'value' => $attribute->$field,
            ];
            $value = $this->calculateAttributeValue($data);
            return $value;
        } catch (Exception $e) {
            return $this->$field;
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

        $baseAttributes = $this->loadedEntity->attributes()->orderBy('default_order')->pluck('value', 'name');

        $this->calculatedAttributes = new Collection();

        // Prepare our attributes with first level references
        foreach ($baseAttributes as $name => $value) {
            $references = [];
            preg_match_all('`\{(.*?)\}`i', $value, $references);

            // Cleanup attribute name to remove range stuff
            $name = preg_replace('`\[range:(.*)\]`i', '', $name);

            $this->calculatedAttributes->put($name, [
                'value' => $value,
                'loop' => false,
                'name' => $name,
                'final' => null,
                'references' => !empty($references[1]) ? $references[1] : [],
            ]);
        }

        // Loop through the attributes and calculate the values
        foreach ($this->calculatedAttributes as $name => $attribute) {
            try {
                $this->calculatedAttributes[$name] = $this->calculateAttribute($attribute);
            } catch (\Exception $e) {
                $attribute['loop'] = true;
                $attribute['final'] = $attribute['value'];
                $this->calculatedAttributes[$name] = $attribute;
            }
        }

        //dd($this->calculatedAttributes);

        return $this->loadedAttributes[$this->loadedEntity->id] = $this->calculatedAttributes;
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
                if ($entity->typeId() != config('entities.ids.attribute_template')) {
                    list ($type, $value) = $this->randomAttribute($type, $value);
                }

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
        } elseif(is_string($templateId)) {
            return $this->applyKankaTemplate($templateId, $entity);
        }
        return false;
    }

    /**
     * @param $template
     * @param Entity $entity
     * @return false|string
     */
    protected function applyKankaTemplate($templateName, Entity $entity)
    {
        $templates = config('attribute-templates.templates');
        if (!Arr::exists($templates, $templateName)) {
            return false;
        }
        /** @var Template $template */
        $template = new $templates[$templateName];
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
                'value' => $templateName,
                'default_order' => $order,
                'is_private' => false,
                'is_star' => false,
                'type' => null,
            ]);
        }


        return $template->name();

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
            $type = $types[$id] ?? '';
            $isPrivate = !empty($privates[$id]);
            $isStar = !empty($stars[$id]);

            if (!empty($existing[$id])) {
                // Edit an existing attribute
                /** @var \App\Models\Attribute $attribute */
                $attribute = $existing[$id];
                $attribute->type = $type;
                $attribute->name = $name;
                $attribute->setValue($value);
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
                if ($entity->typeId() != config('entities.ids.attribute_template')) {
                    list ($type, $value) = $this->randomAttribute($type, $value);
                }

                $attribute = new Attribute([
                    'entity_id' => $entity->id,
                    'type' => $type,
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

    /**
     * @param Campaign $campaign
     * @return array
     */
    public function templates(Campaign $campaign): array
    {
        $templates = [];

        foreach (config('attribute-templates.templates') as $code => $class) {
            $template = new $class;
            $templates[$code] = $template->name();
        }
        // Get templates from the plugins
        if ($campaign->boosted() && config('marketplace.enabled')) {
            foreach(CampaignPlugin::templates($campaign)->get() as $plugin) {
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

        // Kanka templates
        $key = __('attributes/templates.list.kanka');
        foreach (config('attribute-templates.templates') as $code => $class) {
            $template = new $class;
            $templates[$key][$code] = $template->name();
        }

        // If the campaign isn't boosted, or the marketplace isn't enable, end here
        if (!$this->campaign->boosted() || !config('marketplace.enabled')) {
            return $templates;
        }

        // Marketplace campaigns
        $key = __('attributes/templates.list.marketplace');
        foreach(CampaignPlugin::templates($this->campaign)->with(['plugin', 'plugin.user'])->get() as $plugin) {
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
     * @param int $id
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
        if (!$campaign->boosted() || !config('marketplace.enabled')) {
            return null;
        }

        if (!Str::isUuid($uuid)) {
            return null;
        }

        $plugin = CampaignPlugin::templates($campaign)
            ->select('campaign_plugins.*')
            ->leftJoin('plugin_versions as pv', 'pv.plugin_id', 'campaign_plugins.plugin_id')
            ->where('pv.uuid', $uuid)
            ->has('plugin')
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
    protected function getMarketplacePlugin(string $pluginUuid, $campaign)
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
     * @param string $type
     * @param string $value
     * @return array[string, string]
     */
    public function randomAttribute($type, $value)
    {
        // Special case if the attribute is a random
        if ($type != Attribute::TYPE_RANDOM) {
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

    /**
     * @param array $data
     * @return array
     */
    protected function calculateAttribute(array $data)
    {
        if (empty($data['references'])) {
            $data['final'] = $data['value'];
            return $data;
        }

        try {
            $data['final'] = $this->calculateAttributeValue($data, []);
        } catch (Exception $e) {
            //dump($e->getMessage());
            //dd('oh these is a loop in here');
            $data['final'] = 0;
            $data['loop'] = true;
        }
        return $data;


    }

    /**
     * @param string $value
     * @param array $from
     * @return string
     * @throws \ChrisKonnertz\StringCalc\Exceptions\ContainerException
     * @throws \ChrisKonnertz\StringCalc\Exceptions\NotFoundException
     */
    protected function calculateAttributeValue(array $data, array $from = []): string
    {
        // If the final version is already calculated, use that

        //dump('parsing ' . $data['name'] . ' value ' . $data['value']);

        // First detect any loops going on here
        if (in_array($data['name'], $from)) {
            throw new Exception('loop detected on ' . $data['name']);
        }

        // Replace any attribute references
        $final = preg_replace_callback('`\{(.*?)\}`i', function ($matches) use ($data, $from) {
            $text = $matches[1];
            //dump('checking for a reference called ' . $text);
            if ($ref = $this->calculatedAttributes->get($text)) {
                //dump('has an attribute called it!');
                if (!empty($ref['final'])) {
                    //dump('has a final version too');
                    return $ref['final'];
                } elseif ($ref['loop']) {
                    return 0;
                }
                //dump('calculating final version for ' . $text . ' with value ' . $ref['value']);
                $newFrom = $from;
                $newFrom[] = $data['name'];

                    $ref['final'] = $this->calculateAttributeValue($ref, $newFrom);
                    $this->calculatedAttributes[$text] = $ref;
                    return $ref['final'];
                /*} catch (Exception $e) {
                    $ref['loop'] = true;
                    $ref['final'] = $ref['value'];
                    $this->calculatedAttributes[$text] = $ref;
                    return 0;
                }*/
            }
            if ($text == 'name') {
                return (string) $this->loadedEntity->name;
            }
            return 0;
        }, $data['value']);

        try {
            $calculator = new StringCalc();
            $return = (string)$calculator->calculate($final);
            return $return;
        } catch(Exception $e) {
            return $final;
        }
    }

    /**
     * Check if an attribute is part of a loop
     * @param $name
     * @return bool
     */
    public function isLoop($name): bool
    {
        if (empty($this->calculatedAttributes)) {
            return false;
        }
        if ($ref = $this->calculatedAttributes->get($name)) {
            return $ref['loop'];
        }
        return false;
    }

    /**
     * Prepare a custom HTML purifying config for attributes
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
        return $purifyConfig;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function validField(string $value): bool
    {
        if (!Str::contains($value, ['{', '}'])) {
            return false;
        }
        if (Str::contains($value, ['<', '>'])) {
            return false;
        }
        return true;
    }
}
