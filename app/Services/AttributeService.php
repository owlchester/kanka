<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\Entity;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Kanka\Dnd5eMonster\Template;

class AttributeService
{
    /** @var array */
    protected $loadedAttributes = [];

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
            // Replace {} with entity attributes
            $value = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
                $text = $matches[1];
                if ($this->entityAttributes()->has($text)) {
                    return $this->entityAttributes()->get($text);
                }
                return 0;
            }, $attribute->value);

            $calculator = new StringCalc();
            return $calculator->calculate($value);
        } catch(\Exception $e) {
            return '';
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    protected function entityAttributes()
    {
        if (isset($this->loadedAttributes[$this->loadedEntity->id])) {
            return $this->loadedAttributes[$this->loadedEntity->id];
        }

        return $this->loadedAttributes[$this->loadedEntity->id] = $this->loadedEntity->attributes()->pluck('value', 'name');
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
            $template = AttributeTemplate::findOrFail($request['template_id']);
            $template->apply($entity);
            return $template->name;
        } elseif ($communityTemplate) {
            // Oh uh
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

            return false;
        }
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
}
