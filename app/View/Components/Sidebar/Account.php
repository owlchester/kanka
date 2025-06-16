<?php

namespace App\View\Components\Sidebar;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Account extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.account');
    }

    /**
     * Settings menu active
     */
    public function active(string $menu, int $segment = 2): ?string
    {
        $current = request()->segment($segment);
        if ($current == $menu) {
            return ' active';
        }

        return null;
    }
}
