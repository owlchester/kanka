<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dialog extends Component
{
    public string $id;
    public string $title;
    public bool $full;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $id = null, bool $full = false)
    {
        $this->id = $id ?? uniqid();
        $this->title = $title;
        $this->full = $full;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog');
    }
}
