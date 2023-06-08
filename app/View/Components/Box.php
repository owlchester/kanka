<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Box extends Component
{
    public ?string $id;
    public ?string $url;
    public ?string $href;
    public string $css;
    public bool $padding;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id = null,
        string $url = null,
        string $href = null,
        string $css = '',
        bool $padding = true,
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->css = $css;
        $this->href = $href;
        $this->padding = $padding;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.box');
    }
}
