<?php

namespace App\View\Components\Dialog;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public ?string $id;
    public ?string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id = null,
        string $title = null,
    )
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog.header');
    }
}
