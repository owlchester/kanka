<?php

namespace App\Services;

use App\Models\Family;
use App\Models\MiscModel;

class FormService
{
    /**
     * Prefill the field with the copies values
     * @param $field
     * @param null $entity
     * @return mixed|null
     */
    public function prefill($field, $entity = null)
    {
        // Characters have a random generator we need to account for
//        if ($entity instanceof RandomCharacterService) {
//            return $entity->generate($field);
//        }

        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            return $entity->getAttributeValue($field);
        }

        return null;
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
     * @return array
     */
    public function colours()
    {
        $colours = [
            '' => __('crud.none')
        ];
        $colourKeys = config('colours.keys');
        foreach ($colourKeys as $colour) {
            $colours[$colour] = trans('colours.' . $colour);
        }

        return $colours;
    }
}
