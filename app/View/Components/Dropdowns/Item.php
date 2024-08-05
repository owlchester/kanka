<?php

namespace App\View\Components\Dropdowns;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public array $dataProperties;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $link,
        public ?string $target = null,
        public ?string $css = null,
        public ?string $dialog = null,
        public ?string $popup = null,
        public ?string $keyboard = null,
        array $data = [],
        public ?string $icon = null,
        public bool $active = false,
    ) {
        $this->dataProperties = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdowns.item');
    }
}
