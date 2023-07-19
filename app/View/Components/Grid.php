<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Grid extends Component
{
    public ?string $id;
    public ?string $type;
    public ?string $css;
    public bool $hidden;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id = null,
        string $type = null,
        string $css = null,
        bool $hidden = false,
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->css = $css;
        $this->hidden = $hidden;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.grid');
    }
}
