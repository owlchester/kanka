<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Foreign extends Component
{
    public string $name;
    public string $id;
    public ?string $placeholder;
    public mixed $route;
    public mixed $preset;
    public bool $allowNew;
    public bool $allowClear;
    public ?string $entityType;
    public ?string $label;
    public ?string $helper;
    public mixed $model;
    public mixed $options;
    public ?string $dropdownParent;
    public ?string $className;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $id = null,
        string $placeholder = null,
        mixed $preset = null,
        mixed $route = null,
        bool $allowNew = false,
        string $entityType = null,
        bool $allowClear = false,
        string $label = null,
        string $helper = null,
        string $dropdownParent = null,
        mixed $model = null,
        mixed $class = null,
    ) {
        $this->name = $name;
        $this->preset = $preset;
        $this->placeholder = $placeholder;
        $this->route = $route;
        $this->allowNew = $allowNew;
        $this->entityType = $entityType;
        $this->allowClear = $allowClear;
        $this->label = $label;
        $this->model = $model;
        $this->helper = $helper;
        $this->dropdownParent = $dropdownParent;
        $this->options = [];
        $this->id = $id ?? $name . '_' . uniqid();
        $this->className = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $canNew = false;
        if ($this->allowNew && auth()->check() && !empty($this->className)) {
            $canNew = auth()->user()->can('create', new $this->className);
        }
        return view('components.forms.foreign')
            ->with('canNew', $canNew);
    }
}
