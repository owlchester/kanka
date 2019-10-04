<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\Family;
use App\Models\MiscModel;

class FormService
{
    /**
     * @var MiscModel|null
     */
    protected $source;

    /**
     * @param MiscModel|null $source
     * @return $this
     */
    public function source(MiscModel $source = null)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Prefill the field with the copies values
     * @param $field
     * @param null $entity
     * @param null $default
     * @return mixed|null
     */
    public function prefill($field, $entity = null, $default = null)
    {
        // Characters have a random generator we need to account for
//        if ($entity instanceof RandomCharacterService) {
//            return $entity->generate($field);
//        }

        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            return $entity->getAttributeValue($field);
        }

        return $default;
    }

    /**
     * Prefill a select dropdown
     * @param $field
     * @param null $entity
     * @return array
     */
    public function prefillSelect($field, $entity = null, $checkForParent = false, $parentClass = null)
    {
        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            $value = $entity->$field;
            if (!empty($value) and is_object($value)) {
                return [$value->id => $value->name];
            }
        }

        $parent = request()->get('parent_id', false);
        if ($checkForParent && $parent !== false) {
            /** @var Family $class */
            $class = new $parentClass;
            $parent = $class->find($parent);
            if ($parent) {
                return [$parent->id => $parent->name];
            }
        }

        return [];
    }

    /**
     * Character traits
     * @param null $entity
     * @return array
     */
    public function prefillCharacterPersonality($entity = null)
    {
        if ($entity instanceof MiscModel) {
            return $entity->characterTraits()->personality()->get();
        }
        return [];
    }

    /**
     * Character traits
     * @param null $entity
     * @return array
     */
    public function prefillCharacterAppearance($entity = null)
    {
        if ($entity instanceof MiscModel) {
            return $entity->characterTraits()->appearance()->get();
        }
        return [];
    }

    /**
     * Character organisations
     * @param null $entity
     * @return array
     */
    public function prefillCharacterOrganisation($entity = null)
    {
        if ($entity instanceof MiscModel) {
            return $entity->organisations()
                ->with('organisation')
                ->has('organisation')
                ->get();
        }
        return [];
    }

    /**
     * @param $field
     * @param null $entity
     */
    public function prefillBoolean($field, $entity = null)
    {
        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            return $entity->getAttributeValue($field) ? true : false;
        }

        return null;
    }

    /**
     * Prefill model for custom blade directives
     * @param null $entity
     * @return null
     */
    public function prefillModel($entity = null)
    {
        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            return $entity;
        }
        return null;
    }

    /**
     * Prefill a value based on an attribute
     * @param string $field
     * @param MiscModel|null $entity
     * @return mixed
     */
    public function prefillEntity(string $field, $entity = null)
    {
        if ($entity instanceof MiscModel && $entity->entity) {
            return $entity->entity->$field;
        }

        return null;
    }

    /**
     * @return array
     */
    public function colours()
    {
        $colours = [
            '' => __('colours.none')
        ];
        $colourKeys = config('colours.keys');
        foreach ($colourKeys as $colour) {
            $colours[$colour] = trans('colours.' . $colour);
        }

        return $colours;
    }
}
