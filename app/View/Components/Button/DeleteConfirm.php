<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteConfirm extends Component
{
    public string $target;
    public ?string $size;
    public ?string $text;
    public ?string $css;
    public ?bool $iconOnly;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $target,
        string $size = null,
        string $text = null,
        string $css = null,
        bool $iconOnly = false,
    ) {
        $this->target = $target;
        $this->size = $size;
        $this->text = $text;
        $this->css = $css;
        $this->iconOnly = $iconOnly;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button.delete-confirm');
    }
}
