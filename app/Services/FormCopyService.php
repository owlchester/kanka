<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Family;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormCopyService
 * @package App\Services
 */
class FormCopyService
{
    /**
     * @var MiscModel|Model|Character|null
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
    protected bool $entity = false;

    /**
     * @param Model|MiscModel|Character|null $source
     * @return $this
     */
    public function source($source = null): self
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
            /** @var Model $class */
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
     * @return array|Collection
     */
    public function characterPersonality()
    {
        if ($this->valid()) {
            // @phpstan-ignore-next-line
            return $this->source->characterTraits()->personality()->get();
        }
        return [];
    }

    /**
     * Character traits
     * @return array|Collection
     */
    public function characterAppearance()
    {
        if ($this->valid()) {
            // @phpstan-ignore-next-line
            return $this->source->characterTraits()->appearance()->get();
        }
        return [];
    }

    /**
     * Character organisations
     * @return array|Collection
     */
    public function characterOrganisation()
    {
        if ($this->valid()) {
            // @phpstan-ignore-next-line
            return $this->source->organisationMemberships()
                ->with('organisation')
                ->has('organisation')
                ->get();
        }
        return [];
    }

    /**
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
        if (empty($this->source)) {
            return false;
        }
        return method_exists($this->source, 'isCopiableObject') && $this->source->isCopiableObject();
    }

    /**
     * @return mixed
     */
    private function getValue()
    {
        if (!$this->valid()) {
            return null;
        }

        if ($this->entity === true) {
            $this->entity = false;
            // @phpstan-ignore-next-line
            return $this->source->entity->getAttributeValue($this->field);
        }
        return $this->source->getAttributeValue($this->field);
    }

    /**
     * @return mixed
     */
    private function getValues()
    {
        if (!$this->valid()) {
            return null;
        }

        if ($this->entity === true) {
            $this->entity = false;
            // @phpstan-ignore-next-line
            return $this->source->entity->{$this->field};
        }
        return $this->source->{$this->field};
    }
}
