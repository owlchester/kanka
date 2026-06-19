<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PermissionToggle extends Component
{
    public function __construct(
        public string $name,
        public string $selected = 'inherit',
        public bool $inherited = false,
        public bool $inheritedAccess = true,
        public string $label = '',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.forms.permission-toggle');
    }
}
