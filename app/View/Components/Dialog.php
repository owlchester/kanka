<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dialog extends Component
{
    public string $id;
    public string $title;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $id = null)
    {
        $this->id = $id ?? uniqid();
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dialog');
    }
}
