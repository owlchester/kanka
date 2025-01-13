<?php

namespace App\View\Components;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InfoBox extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $icon,
        public ?string $url,
        public ?string $subtitle,
        public ?string $color,
        public ?string $urlTooltip,
        public ?Campaign $campaign,
        public string $target = 'primary-dialog',
        public string $background = 'bg-neutral',
        public string $subtitleColour = 'text-neutral-content',
        public string $urlIcon = 'fa-solid fa-angle-right',
        public bool $ajax = false,
        public bool $premium = false,
    ) {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.info-box');
    }
}
