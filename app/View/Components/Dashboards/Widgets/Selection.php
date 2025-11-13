<?php

namespace App\View\Components\Dashboards\Widgets;

use App\Enums\Widget;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Selection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?CampaignDashboard $dashboard,
        public Campaign $campaign,
        public Widget $widget,
        public string $icon,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboards.widgets.selection');
    }
}
