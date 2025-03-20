<?php

namespace App\View\Components;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cta extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        public ?string $title = null,
        public ?string $cta = null,
        public bool $image = true,
        public bool $limit = false,
        public bool $superboost = false,
        public bool $premium = false,
        public bool $minimal = false,
        public bool $max = false,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $legacy = auth()->check() && auth()->user()->hasBoosterNomenclature();

        return view('components.cta')
            ->with('legacy', $legacy);
    }
}
