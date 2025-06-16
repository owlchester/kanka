<?php

namespace App\View\Components\Sidebar;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Settings extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.settings');
    }

    public function active(string|array $options): ?string
    {
        if (! is_array($options)) {
            $options = [$options];
        }
        if (in_array(request()->segment(3), $options)) {
            return 'active';
        }

        return null;
    }
}
