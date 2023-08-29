<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dialog extends Component
{
    public string $id;
    public ?string $title;
    public ?string $footer;
    public bool $full;
    public bool $loading;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title = null,
        string $id = null,
        string $footer = null,
        bool $full = false,
        bool $loading = false,
    ) {
        $this->id = $id ?? uniqid();
        $this->title = $title;
        $this->full = $full;
        $this->loading = $loading;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog');
    }
}
