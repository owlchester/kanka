<?php

namespace App\View\Components\Reorder;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Child extends Component
{
    public mixed $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        mixed $id
    ) {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.reorder.child');
    }
}
