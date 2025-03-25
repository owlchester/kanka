<?php

namespace App\View\Components\Forms;

use App\Facades\Module;
use App\Models\Campaign;
use App\Models\EntityType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Foreign extends Component
{
    // public mixed $model;
    public array $options = [];

    protected EntityType $entityType;

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
        public string $key = '',
        public ?string $label = null,
        public ?string $placeholder = null,
        public ?string $helper = null,
        public ?string $dropdownParent = null,
        public ?int $entityTypeID = null,
        public ?string $dynamicTag = null,
    ) {
        $this->id = ! empty($id) ? $id : $name . '_' . uniqid();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $canNew = $this->createPermission();

        if (! empty($this->selected)) {
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
        } elseif (! empty($this->key)) {
            if (empty($this->label)) {
                $this->label = ! empty($this->entityTypeID) ? __('entities.' . $this->key) : __('crud.fields.' . $this->key);
                if (! empty($this->entityTypeID)) {
                    $this->label = Module::singular($this->entityTypeID, $this->label);
                }
            }
            if (empty($this->placeholder)) {
                $this->placeholder = __('crud.placeholders.' . $this->key);
                if (! empty($this->entityTypeID)) {
                    $mod = Module::singular($this->entityTypeID);
                    if (! empty($mod)) {
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

    protected function createPermission(): bool
    {
        if (! $this->allowNew || auth()->guest()) {
            return false;
        }

        if (! empty($this->entityType)) {
            return auth()->user()->can('create', [$this->entityType, $this->campaign]);
        }

        $this->entityType = $this->campaign->getEntityTypes()->where('id', $this->entityTypeID)->first();

        return auth()->user()->can('create', [$this->entityType, $this->campaign]);
    }
}
