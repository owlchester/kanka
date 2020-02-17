<?php

namespace App\Services;

use App\Models\Family;
use App\Models\MiscModel;

/**
 * Class FormCopyService
 * @package App\Services
 */
class FormCopyService
{
    /**
     * @var MiscModel|null
     */
    protected $source;

    /**
     * The requested field
     * @var string
     */
    protected $field;

    /**
     * If the field comes from the entity
     * @var bool
     */
    protected $entity = false;

    /**
     * @param MiscModel|null $source
     * @return $this
     */
    public function source(MiscModel $source = null): self
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @param string $field
     * @return FormCopyService
     */
    public function field(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Set the request to be on the entity
     * @return FormCopyService
     */
    public function entity(): self
    {
        $this->entity = true;
        return $this;
    }

    /**
     * @param string|null $default
     * @return string|null
     */
    public function string($default = null)
    {
        if ($this->valid()) {
            return $this->getValue();
        }

        return $default;
    }

    /**
     * Get values for a select field
     * @param bool $checkForParent
     * @param string|null $parentClass
     * @return array
     */
    public function select(bool $checkForParent = false, string $parentClass = null)
    {
        // Only copy on MiscModel (entity) models
        if ($this->valid()) {
            $value = $this->getValues();
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
     * @return array
     */
    public function characterPersonality()
    {
        if ($this->valid()) {
            return $this->source->characterTraits()->personality()->get();
        }
        return [];
    }

    /**
     * Character traits
     * @param null $entity
     * @return array
     */
    public function characterAppearance()
    {
        if ($this->valid()) {
            return $this->source->characterTraits()->appearance()->get();
        }
        return [];
    }

    /**
     * Character organisations
     * @param null $entity
     * @return array
     */
    public function characterOrganisation()
    {
        if ($this->valid()) {
            return $this->source->organisations()
                ->with('organisation')
                ->has('organisation')
                ->get();
        }
        return [];
    }

    /**
     * @param string $field
     * @param bool $default
     * @return bool
     */
    public function boolean(bool $default = false): bool
    {
        // Only copy on MiscModel (entity) models
        if ($this->valid()) {
            return $this->getValue() ? true : false;
        }

        return $default;
    }

    /**
     * Prefill model for custom blade directives
     * @param null $entity
     * @return null
     */
    public function model()
    {
        // Only copy on MiscModel (entity) models
        if ($this->valid()) {
            return $this->source;
        }
        return null;
    }

    /**
     * Prefill model for custom blade directives
     * @param null $entity
     * @return null
     */
    public function related()
    {
        // Only copy on MiscModel (entity) models
        if ($this->valid()) {
            return $this->source->{$this->field};
        }
        return null;
    }

    /**
     * @param bool $withNull include "none" option
     * @return array
     */
    public function colours(bool $withNull = true): array
    {
        $colours = $withNull ? [
            '' => __('colours.none')
        ] : [];
        $colourKeys = config('colours.keys');
        foreach ($colourKeys as $colour) {
            $colours[$colour] = trans('colours.' . $colour);
        }

        asort($colours);
        return $colours;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    /**
     * @return bool
     */
    private function valid(): bool
    {
        return $this->source instanceof MiscModel;
    }

    /**
     * @param bool $attributeValue
     * @return mixed
     */
    private function getValue()
    {
        if (!$this->valid()) {
            return null;
        }

        if ($this->entity === true) {
            $this->entity = false;
            return $this->source->entity->getAttributeValue($this->field);
        }
        return $this->source->getAttributeValue($this->field);
    }

    /**
     * @param bool $attributeValue
     * @return mixed
     */
    private function getValues()
    {
        if (!$this->valid()) {
            return null;
        }

        if ($this->entity === true) {
            $this->entity = false;
            return $this->source->entity->{$this->field};
        }
        return $this->source->{$this->field};
    }
}
