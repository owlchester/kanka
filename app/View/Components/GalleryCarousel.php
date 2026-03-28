<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GalleryCarousel extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $images = [],
        public bool $showName = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gallery-carousel');
    }
}
