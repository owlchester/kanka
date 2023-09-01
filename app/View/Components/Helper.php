<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Helper extends Component
{
    public ?string $text;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $text = null,
    )
    {
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.helper');
    }
}
