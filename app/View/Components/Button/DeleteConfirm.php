<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteConfirm extends Component
{
    public string $target;
    public ?string $size;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $target,
        string $size = null,
    )
    {
        $this->target = $target;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button.delete-confirm');
    }
}
