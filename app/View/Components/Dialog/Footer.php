<?php

namespace App\View\Components\Dialog;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public bool $modal;
    public bool $dialog;
    /**
     * Create a new component instance.
     */
    public function __construct(
        bool $modal = false,
        bool $dialog = false,
    )
    {
        $this->modal = $modal;
        $this->dialog = $dialog;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog.footer');
    }
}
