<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Entity;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class FormService
{
    /**
     * @var MiscModel|null
     */
    protected $source;

    /**
     * @return $this
     */
    public function source(MiscModel $source = null)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Prefill the field with the copies values
     * @param string $field
     * @param MiscModel|Entity|null $entity
     * @return mixed|null
     */
    public function prefill($field, $entity = null, $default = null)
    {
        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            return $entity->getAttributeValue($field);
        }

        return $default;
    }

    /**
     * Prefill a select dropdown
     * @param string $field
     * @param null|MiscModel|Model $entity
     * @param bool $checkForParent
     * @return array
     */
    public function prefillSelect($field, $entity = null, $checkForParent = false, $parentClass = null)
    {
        // Only copy on MiscModel (entity) models
        if ($entity instanceof MiscModel) {
            $value = $entity->$field;
            if (!empty($value) && is_object($value)) {
                return [$value->id => $value->name];
            }
        }

        $parent = request()->get('parent_id', false);
        if ($checkForParent && $parent !== false) {
            /** @var MiscModel $class */
            $class = new $parentClass();
            /** @var MiscModel|null $parent */
            $parent = $class->find($parent);
            if ($parent) {
                return [$parent->id => $parent->name];
            }
        }

        return [];
    }

    /**
     * Character traits
     * @param null|MiscModel|Character $entity
     * @return array|Collection
     */
    public function prefillCharacterPersonality($entity = null)
    {
        if ($entity instanceof Character) {
            return $entity->characterTraits()->personality()->get();
        }
        return [];
    }

    /**
     * Character traits
     * @param null|MiscModel|Character $entity
     * @return array|Collection
     */
    public function prefillCharacterAppearance($entity = null)
    {
        if ($entity instanceof Character) {
            return $entity->characterTraits()->appearance()->get();
        }
        return [];
    }

    /**
     * Character organisations
     * @param null|Character $entity
     * @return array|Collection
     */
    public function prefillCharacterOrganisation($entity = null)
    {
        if ($entity instanceof MiscModel) {
            return $entity->organisationMemberships()
                ->with('organisation')
                ->has('organisation')
                ->get();
        }
        return [];
    }

    /**
     * @param string $field
     * @param null|MiscModel $entity
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
     * @param null|MiscModel $entity
     * @return null|MiscModel
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
     * @param MiscModel|null $entity
     */
    public function prefillEntity(string $field, $entity = null)
    {
        if ($entity instanceof MiscModel && !empty($entity->entity)) {
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
            $colours[$colour] = __('colours.' . $colour);
        }

        return $colours;
    }
}
