<?php

namespace App\View\Components\Menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Element extends Component
{
    public string $route;
    public bool $active;
    public int $badge;
    public array|null $button;
    public string|null $ajax;
    public string|null $id;


    /**
     * Create a new component instance.
     */
    public function __construct(
        string $route,
        bool $active = false,
        int $badge = 0,
        array $button = null,
        string $ajax = null,
        string $id = null,
    ) {
        $this->route = $route;
        $this->active = $active;
        $this->badge = $badge;
        $this->button = $button;
        $this->ajax = $ajax;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.element');
    }
}
