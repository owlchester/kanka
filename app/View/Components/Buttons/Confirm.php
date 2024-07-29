<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Confirm extends Component
{
    use Colours;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $type = null,
        public ?string $target = null,
        public bool $full = false,
        public bool $outline = false,
        public ?string $name = null,
        public ?string $size = null,
        public ?string $dismiss = null,
        public ?string $id = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons.confirm')
            ->with('colours', $this->colour())
            ->with('sizes', $this->size())
            ->with('element', $this->dismiss == 'dialog' ? 'a' : 'button')
        ;
    }

    protected function size(): string
    {
        if ($this->size === 'sm') {
            return 'btn-sm';
        }
        return '';
    }
}
