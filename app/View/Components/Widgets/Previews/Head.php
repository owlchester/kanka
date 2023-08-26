<?php

namespace App\View\Components\Widgets\Previews;

use App\Facades\Img;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Entity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Head extends Component
{
    public Campaign $campaign;
    public CampaignDashboardWidget $widget;
    public Entity $entity;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Campaign $campaign,
        CampaignDashboardWidget $widget,
        Entity $entity,
    ) {
        $this->campaign = $campaign;
        $this->widget = $widget;
        $this->entity = $entity;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.widgets.previews.head')
            ->with('image', $this->headerImage());
    }

    protected function headerImage(): null|string
    {
        if ($this->widget->conf('entity-header') && $this->campaign->boosted() && $this->entity->header_image) {
            return $this->entity->thumbnail(1200, 400, 'header_image');
        } elseif ($this->widget->conf('entity-header') && $this->campaign->boosted() && $this->widget->entity->header) {
            return $this->entity->header->path;
        } elseif ($this->entity->image) {
            return Img::crop(1200, 400)->url($this->entity->image->path);
        } elseif ($this->entity->child->image) {
            return $this->entity->child->thumbnail(400);
        }
        return null;
    }
}
