<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Field extends Component
{
    public string $field;
    public ?string $label;
    public bool $required;
    public bool $tooltip;
    public ?string $helper;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $field,
        string $label = null,
        bool $required = false,
        bool $tooltip = false,
        string $helper = null,
    ) {
        $this->field = $field;
        $this->label = $label;
        $this->required = $required;
        $this->tooltip = $tooltip;
        $this->helper = $helper;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.field');
    }
}
