<?php

namespace App\View\Components\Forms;

use App\Facades\Module;
use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Foreign extends Component
{
    //public mixed $model;
    public array $options = [];
    public ?string $className;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        public string $name,
        public string $id = '',
        public mixed $selected = null,
        public mixed $route = null,
        public bool $allowNew = false,
        public bool $dynamicNew = false,
        public bool $allowClear = false,
        public bool $required = false,
        public bool $parent = false,
        public bool $multiple = false,
        public string $entityType = '',
        public string $key = '',
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public ?string $dropdownParent = null,
        public ?int $entityTypeID = null,
        mixed $class = null,
    ) {
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
            $canNew = auth()->user()->can('create', new $this->className());
        }

        if (!empty($this->selected)) {
            if (is_array($this->selected)) {
                $this->options = $this->selected;
            } elseif ($this->selected instanceof Model) {
                // @phpstan-ignore-next-line
                $this->options[$this->selected->id] = $this->selected->name;
            }
        }

        if ($this->parent) {
            $this->label = __('crud.fields.parent');
            $this->placeholder = __('crud.placeholders.parent');
        } elseif (!empty($this->key)) {
            if (empty($this->label)) {
                $this->label = !empty($this->entityTypeID) ? __('entities.' . $this->key) : __('crud.fields.' . $this->key);
                if (!empty($this->entityTypeID)) {
                    $this->label = Module::singular($this->entityTypeID, $this->label);
                }
            }
            if (empty($this->placeholder)) {
                $this->placeholder = __('crud.placeholders.' . $this->key);
                if (!empty($this->entityTypeID)) {
                    $mod = Module::singular($this->entityTypeID);
                    if (!empty($mod)) {
                        $this->placeholder = __('crud.placeholders.fallback', ['module' => Module::singular($this->entityTypeID, $this->label)]);
                    }
                }
            }
        } else {
            if (empty($this->label)) {
                $this->label = '';
            }
            if (empty($this->placeholder)) {
                $this->placeholder = '';
            }
        }
        return view('components.forms.foreign')
            ->with('canNew', $canNew);
    }
}
