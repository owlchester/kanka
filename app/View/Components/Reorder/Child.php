<?php

namespace App\View\Components\Reorder;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Child extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public mixed $id
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reorder.child');
    }
}
