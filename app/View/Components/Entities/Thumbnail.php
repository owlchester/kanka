<?php

namespace App\View\Components\Entities;

use App\Models\Entity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Thumbnail extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Entity $entity,
        public ?string $title = null,
        public int $size = 40
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entities.thumbnail');
    }
}
