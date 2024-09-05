<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dialog extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string|null $title = null,
        public string|null $id = null,
        public string|null $footer = null,
        public array $form = [],
        public bool $full = false,
        public bool $loading = false,
        public bool $dismissible = true,
    ) {
        if (empty($this->id)) {
            $this->id = uniqid();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog');
    }
}
