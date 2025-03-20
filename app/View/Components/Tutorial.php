<?php

namespace App\View\Components;

use App\Facades\UserCache;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tutorial extends Component
{
    public string $id;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $code,
        public ?string $doc = null,
        public ?string $type = null,
        public bool $auth = true
    ) {
        $this->id = uniqid($code . '-');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->auth && ! auth()->check()) {
            return '';
        }
        if (auth()->check() && UserCache::dismissedTutorial($this->code)) {
            return '';
        }

        return view('components.tutorial');
    }
}
