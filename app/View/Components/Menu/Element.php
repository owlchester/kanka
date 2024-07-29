<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Element extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $route,
        public bool $active = false,
        public int $badge = 0,
        public ?array $button = null,
        public ?string $ajax = null,
        public ?string $id = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.element');
    }
}
