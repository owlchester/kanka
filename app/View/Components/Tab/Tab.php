<?php

namespace App\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tab extends Component
{
    public string $target;
    public string $title;
    public ?string $icon;
    public bool $default;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $target,
        string $title,
        string $icon = null,
        bool $default = false,
    ) {
        $this->target = $target;
        $this->title = $title;
        $this->icon = $icon;
        $this->default = $default;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab.tab');
    }
}
