<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Box extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public null|string $id = null,
        public null|string $url = null,
        public null|string $href = null,
        public array $extra = [],
        public string $css = '',
        public bool $padding = true,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.box');
    }
}
