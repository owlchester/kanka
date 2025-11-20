<?php

namespace App\View\Components;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PremiumCta extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        public bool $superboosted = false,
        public bool $premium = false
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $legacy = auth()->check() && auth()->user()->hasBoosterNomenclature();
        $amount = 4.99;
        $currency = 'US$';
        if (auth()->check()) {
            if (auth()->user()->billedInBrl()) {
                $amount = 19.99;
            }
        }

        return view('components.premium-cta')
            ->with('legacy', $legacy)
            ->with('currency', $currency)
            ->with('amount', $amount);
    }
}
