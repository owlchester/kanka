<?php

namespace App\View\Components\Toggles;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $count,
        public string $route,
        public bool $all = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toggles.filter-button');
    }
}
