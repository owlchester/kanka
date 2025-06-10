<?php

namespace App\View\Components\Sidebar;

use App\Models\Campaign;
use App\Services\Bookmarks\RoutingService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bookmark extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        public \App\Models\Bookmark $bookmark,
        public RoutingService $routingService,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $url = $this->routingService
            ->campaign($this->campaign)
            ->bookmark($this->bookmark)
            ->url();

        return view('components.sidebar.element-link')
            ->with('url', $url)
            ->with('icon', $this->bookmark->iconClass())
            ->with('text', $this->bookmark->name)
            ->with('class', '');
    }
}
