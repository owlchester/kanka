<?php

namespace App\View\Components\Dropdowns;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public string $link;
    public ?string $target;
    public ?string $css;
    public ?string $popup;
    public ?string $dialog;
    public ?string $keyboard;
    public array $dataProperties;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $link,
        string $target = null,
        string $css = null,
        string $dialog = null,
        string $popup = null,
        string $keyboard = null,
        array $data = [],
    ) {
        $this->link = $link;
        $this->target = $target;
        $this->css = $css;
        $this->dialog = $dialog;
        $this->popup = $popup;
        $this->keyboard = $keyboard;
        $this->dataProperties = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdowns.item');
    }
}
