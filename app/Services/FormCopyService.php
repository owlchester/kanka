<?php

namespace App\Services;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Traits\RequestAware;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormCopyService
 */
class FormCopyService
{
    use RequestAware;

    protected Entity|Model $source;

    /**
     * The requested field
     *
     * @var string
     */
    protected $field;

    protected bool $fromChild = false;

    public function child(): self
    {
        $this->fromChild = true;

        return $this;
    }

    public function source(Entity|Model|null $source = null): self
    {
        $this->source = $source;

        return $this;
    }

    public function field(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param  string|null  $default
     * @return string|null
     */
    public function string(mixed $default = null)
    {
        if ($this->valid()) {
            return $this->getValue();
        }

        return $default;
    }

    /**
     * Get values for a select field
     */
    public function select(bool $checkForParent = false, ?string $parentClass = null): array
    {
        // Only copy on MiscModel (entity) models
        if ($this->valid()) {
            $value = $this->getValues();
            if (! empty($value) && is_object($value)) {
                return [$value->id => $value->name];
            }
        }

        $parent = isset($this->request) ? $this->request?->get('parent_id', false) : false;
        if ($checkForParent && $parent !== false) {
            /** @var Model $class */
            $class = new $parentClass;
            /** @var ?MiscModel $parent */
            $parent = $class->find($parent);
            if ($parent) {
                return [$parent->id => $parent->name];
            }
        }

        return [];
    }

    /**
     * Character traits
     */
    public function characterPersonality(): Collection
    {
        if ($this->valid()) {
            $this->fromChild = false;

            // @phpstan-ignore-next-line
            return $this->source->child->characterTraits()->personality()->get();
        }

        return new Collection;
    }

    /**
     * Character traits
     */
    public function characterAppearance(): Collection
    {
        if ($this->valid()) {
            $this->fromChild = false;

            // @phpstan-ignore-next-line
            return $this->source->child->characterTraits()->appearance()->get();
        }

        return new Collection;
    }

    /**
     * Character organisations
     */
    public function characterOrganisation(): Collection
    {
        if ($this->valid()) {
            $this->fromChild = false;

            // @phpstan-ignore-next-line
            return $this->source->child->organisationMemberships()
                ->with('organisation')
                ->has('organisation')
                ->get();
        }

        return new Collection;
    }

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
     */
    public function model(): ?MiscModel
    {
        // Only copy on MiscModel (entity) models
        if ($this->valid()) {
            // @phpstan-ignore-next-line
            return $this->source->child;
        }

        return null;
    }

    /**
     * Prefill model for custom blade directives
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
     * @param  bool  $withNull  include "none" option
     */
    public function colours(bool $withNull = true): array
    {
        $colours = $withNull ? [
            '' => __('colours.none'),
        ] : [];
        $colourKeys = config('colours.keys');
        foreach ($colourKeys as $colour) {
            $colours[$colour] = trans('colours.' . $colour);
        }

        asort($colours);

        return $colours;
    }

    public function __toString(): string
    {
        return (string) $this->getValue();
    }

    private function valid(): bool
    {
        return ! empty($this->source);
    }

    private function getValue()
    {
        if (! $this->valid()) {
            return null;
        }

        if (! $this->source instanceof Entity || ! $this->fromChild) {
            return $this->source->getAttributeValue($this->field);
        }
        $this->fromChild = false;
        if ($this->source->isMissingChild()) {
            return null;
        }

        return $this->source->child->getAttributeValue($this->field);
    }

    private function getValues()
    {
        if (! $this->valid()) {
            return null;
        }

        if (! $this->source instanceof Entity || ! $this->fromChild) {
            return $this->source->{$this->field};
        }
        $this->fromChild = false;
        if ($this->source->isMissingChild()) {
            return null;
        }

        return $this->source->child->{$this->field};
    }
}
