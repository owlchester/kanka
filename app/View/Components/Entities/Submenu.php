<?php

namespace App\View\Components\Entities;

use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Submenus\SubmenuService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Submenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Entity $entity,
        public Campaign $campaign,
        public ?string $active = null,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entities.submenu')
            ->with('items', $this->items());
    }

    protected function items(): array
    {
        /** @var SubmenuService $service */
        $service = app()->make(SubmenuService::class);
        return $service
            ->campaign($this->campaign)
            ->entity($this->entity)
            ->items();
    }
}
