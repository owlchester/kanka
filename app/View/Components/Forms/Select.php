<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    protected string $autoId;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public array|Collection $options,
        public array|Collection $optionAttributes = [],
        public string $id = '',
        public bool $required = false,
        public bool $multiple = false,
        public bool $radio = false,
        public string $class = '',
        public string $label = '',
        public string $placeholder = '',
        public mixed $selected = null,
        public array $extra = [],
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Form submitted? Re-load the value
        $old = old($this->name);
        if (null !== $old) {
            $this->selected = $old;
        } elseif (!empty($this->placeholder)) {
            $this->selected = '';
            $this->options = ['' => $this->placeholder] + $this->options;
        }
        return view('components.forms.select');
    }

    public function fieldId(): string
    {
        if (!empty($this->id)) {
            return $this->id;
        }
        return $this->autoId ?? $this->autoId = uniqid($this->name);
    }

    public function isSelected(mixed $value): bool
    {
        if (empty($this->selected)) {
            return empty($value);
        }
        if (is_array($this->selected)) {
            return in_array($value, $this->selected);
        }
        if (is_int($this->selected)) {
            return $value == $this->selected;
        }
        // Always force values to lower to avoid thinking
        return mb_strtolower($value) == mb_strtolower($this->selected);
    }

    public function optionAttributes(string $key): array
    {
        return $this->optionAttributes[$key] ?? [];
    }
}
