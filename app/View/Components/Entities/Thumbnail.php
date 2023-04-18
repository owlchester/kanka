<?php

namespace App\View\Components\Entities;

use App\Models\Entity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Thumbnail extends Component
{
    public int $size;
    public string $title;
    public Entity $entity;
    /**
     * Create a new component instance.
     */
    public function __construct(Entity $entity, string $title = null, int $size = 40)
    {
        $this->entity = $entity;
        $this->title = $title;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entities.thumbnail');
    }
}
