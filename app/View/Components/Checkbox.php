<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public string $text;

    public ?array $dataProperties;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $text,
        ?array $data = [],
    ) {
        $this->text = $text;
        $this->dataProperties = $data;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.checkbox');
    }
}
