<?php

namespace App\View\Components\Forms;

use App\Facades\Module;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Foreign extends Component
{
    public string $name;
    public string $id;
    public ?string $key;
    public mixed $route;
    public mixed $selected;
    public bool $parent;
    public bool $allowNew;
    public bool $allowClear;
    public bool $required;
    public ?string $entityType;
    public ?string $label;
    public ?string $placeholder;
    public ?string $helper;
    //public mixed $model;
    public array $options = [];
    public ?string $dropdownParent;
    public ?string $className;
    public ?int $entityTypeID;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $id = null,
        mixed $selected = null,
        mixed $route = null,
        bool $allowNew = false,
        bool $allowClear = false,
        bool $required = false,
        bool $parent = false,
        string $entityType = null,
        string $key = null,
        string $label = null,
        string $placeholder = null,
        string $helper = null,
        string $dropdownParent = null,
        int $entityTypeID = null,
        //mixed $model = null,
        mixed $class = null,
    ) {
        $this->name = $name;
        $this->selected = $selected;
        $this->route = $route;
        $this->allowNew = $allowNew;
        $this->entityType = $entityType;
        $this->allowClear = $allowClear;
        $this->key = $key;
        $this->parent = $parent;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->required = $required;
        //$this->model = $model;
        $this->helper = $helper;
        $this->dropdownParent = $dropdownParent;
        $this->id = $id ?? $name . '_' . uniqid();
        $this->className = $class;
        $this->entityTypeID = $entityTypeID;
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

        if (!empty($this->selected)) {
            if (is_array($this->selected)) {
                $this->options = $this->selected;
            } elseif ($this->selected instanceof Model) {
                $this->options[$this->selected->id] = $this->selected->name;
            }
        }

        if ($this->parent) {
            $this->label = __('crud.fields.parent');
            $this->placeholder = __('crud.placeholders.parent');
        } elseif (!empty($this->key)) {
            if (empty($this->label)) {
                $this->label = __('crud.fields.' . $this->key);
                if (!empty($this->entityTypeID)) {
                    $this->label = Module::singular($this->entityTypeID, $this->label);
                }
            }
            if (empty($this->placeholder)) {
                $this->placeholder = __('crud.placeholders.' . $this->key);
            }
        } else {
            if (empty($this->label)) {
                $this->label = __('crud.users.unknown');
            }
            if (empty($this->placeholder)) {
                $this->placeholder = '';
            }
        }
        return view('components.forms.foreign')
            ->with('canNew', $canNew);
    }
}

