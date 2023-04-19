<?php

namespace App\View\Components;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cta extends Component
{
    public ?string $title;
    public ?string $cta;
    public Campaign $campaign;
    public bool $image;
    public bool $limit;
    public bool $superboost;
    public bool $minimal;
    /**
     * Create a new component instance.
     */
    public function __construct(
        Campaign $campaign,
        string $title = null,
        string $cta = null,
        bool $image = true,
        bool $limit = false,
        bool $superboost = false,
        bool $minimal = false,
    ) {
        $this->campaign = $campaign;
        $this->title = $title;
        $this->cta = $cta;
        $this->image = $image;
        $this->limit = $limit;
        $this->superboost = $superboost;
        $this->minimal = $minimal;
    }

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
