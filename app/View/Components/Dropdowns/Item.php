<?php

namespace App\View\Components\Dropdowns;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Item extends Component
{
    public array $dataProperties;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $link,
        public ?string $target = null,
        public ?string $css = null,
        public ?string $dialog = null,
        public ?string $popup = null,
        public ?string $keyboard = null,
        public ?string $shortcut = null,
        array $data = [],
        public ?string $icon = null,
        public bool $active = false,
    ) {
        $this->dataProperties = $data;

        if ($this->shortcut !== null) {
            $userAgent = request()->header('User-Agent', '');
            if (Str::contains($userAgent, 'Macintosh') || Str::contains($userAgent, 'Mac OS')) {
                $this->shortcut = str_ireplace('ctrl', '⌘', $this->shortcut);
            }
        }
        $this->shortcut = Str::replace('Shift', '<i class="fa-regular fa-up" aria-hidden="true"></i>', $this->shortcut);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdowns.item');
    }
}
