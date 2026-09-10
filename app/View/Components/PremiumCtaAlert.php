<?php

namespace App\View\Components;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PremiumCtaAlert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        public string $source)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.premium-cta-alert');
    }
}
