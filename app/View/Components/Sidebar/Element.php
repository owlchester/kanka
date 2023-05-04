<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Element extends Component
{
    public string $text;
    public string $icon;
    public string|null $url;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $icon,
        string $text,
        string $url = null,
    )
    {
        $this->text = $text;
        $this->icon = $icon;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $view = 'link';
        if (empty($this->url)) {
            $view = 'text';
        }
        return view('components.sidebar.element-' . $view);
    }
}
