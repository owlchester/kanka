<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tutorial extends Component
{
    public string $code;
    public ?string $doc;
    /**
     * Create a new component instance.
     */
    public function __construct(string $code, string $doc = null)
    {
        $this->code = $code;
        $this->doc = $doc;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!auth()->check() || auth()->user()->settings()->get('tutorial_' . $this->code)) {
            return '';
        }
        return view('components.tutorial');
    }
}
