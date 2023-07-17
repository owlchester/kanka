<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $type;
    public ?string $id;
    public ?string $class;
    public bool $dismissible;
    public bool $hidden;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type,
        string $id = null,
        string $class = null,
        bool $dismissible = false,
        bool $hidden = false,
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->class = $class;
        $this->dismissible = $dismissible;
        $this->hidden = $hidden;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
