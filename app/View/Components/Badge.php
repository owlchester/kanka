<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public string $type;
    public ?string $css;
    public ?string $title;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'default',
        string $css = null,
        string $title = null,
    ) {
        $this->type = $type;
        $this->css = $css;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
        // ->with('colour', $this->colour());
    }

    public function colour(): string
    {
        if ($this->type === 'default') {
            return '';
        }
        return 'badge-' . $this->type;
    }
}
