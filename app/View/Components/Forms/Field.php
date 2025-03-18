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
    public bool $hidden;
    public ?string $helper;
    public ?string $link;
    public ?string $css;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $field,
        ?string $label = null,
        bool $required = false,
        bool $tooltip = false,
        bool $hidden = false,
        ?string $helper = null,
        ?string $link = null,
        ?string $css = null,
        public ?string $id = null,
    ) {
        $this->field = $field;
        $this->label = $label;
        $this->required = $required;
        $this->tooltip = $tooltip;
        $this->hidden = $hidden;
        $this->helper = $helper;
        $this->link = $link;
        $this->css = $css;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.field');
    }
}
