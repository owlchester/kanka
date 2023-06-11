<?php

namespace App\View\Components\Dialog;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Close extends Component
{
    public string $dismiss;
    public bool $modal;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $dismiss = 'modal',
        bool $modal = false,
    )
    {
        $this->dismiss = $dismiss;
        $this->modal = $modal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog.close');
    }
}
