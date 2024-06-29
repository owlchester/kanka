<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Grid extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(
        public null|string $id = null,
        public null|string $type = null,
        public null|string $css = null,
        public bool $hidden = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.grid');
    }
}
