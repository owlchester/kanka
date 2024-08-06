<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'default',
        public string|null $css = null,
        public string|null $title = null,
    ) {
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
