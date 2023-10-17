<?php

namespace App\View\Components\Widgets\Previews;

use App\Facades\Avatar;
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
            ->with('images', $this->headerImage());
    }

    protected function headerImage(): null|array
    {
        if ($this->widget->conf('entity-header') && $this->campaign->boosted() && $this->entity->header_image) {
            return [
                'wide' => $this->entity->thumbnail(1200, 400, 'header_image'),
                'square' => $this->entity->thumbnail(1200, 1200, 'header_image'),
            ];
        } elseif ($this->widget->conf('entity-header') && $this->campaign->boosted() && $this->widget->entity->header) {
            return [
                'wide' => $this->entity->header->getUrl(1200, 400),
                'square' => $this->entity->header->getUrl(1200, 1200),
            ];
        } elseif ($this->entity->image) {
            return [
                'wide' => Img::crop(1200, 400)->url($this->entity->image->path),
                'square' => Img::crop(1200, 1200)->url($this->entity->image->path),
            ];
        } elseif ($this->entity->image_path) {
            return [
                'wide' => Avatar::entity($this->entity)->size(1200, 400)->thumbnail(),
                'square' => Avatar::entity($this->entity)->size(1200, 1200)->thumbnail(),
            ];
        }
        return null;
    }
}
