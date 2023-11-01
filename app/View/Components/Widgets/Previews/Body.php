<?php

namespace App\View\Components\Widgets\Previews;

use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Entity;
use App\Models\MiscModel;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Body extends Component
{
    public Campaign $campaign;
    public CampaignDashboardWidget $widget;
    public Entity $entity;
    public MiscModel $model;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Campaign $campaign,
        CampaignDashboardWidget $widget,
        Entity $entity,
        MiscModel $model,
    ) {
        $this->campaign = $campaign;
        $this->widget = $widget;
        $this->entity = $entity;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.previews.body');
    }
}
