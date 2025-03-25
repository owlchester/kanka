<?php

namespace App\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tab extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $target,
        public string $title,
        public ?string $icon = null,
        public bool $default = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab.tab');
    }
}
