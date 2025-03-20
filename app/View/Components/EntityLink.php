<?php

namespace App\View\Components;

use App\Models\Campaign;
use App\Models\Entity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EntityLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Entity $entity,
        public Campaign $campaign,
        public ?string $name = null,
        public ?string $post = null,
        public bool $bottom = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (empty($this->entity)) {
            return '';
        }

        return view('components.entity-link');
    }

    public function name(): string
    {
        if (! empty($this->name)) {
            return $this->name;
        }

        return $this->entity->name;
    }

    public function post(): string
    {
        if (! empty($this->post)) {
            return '#post-' . $this->post;
        }

        return '';
    }
}
