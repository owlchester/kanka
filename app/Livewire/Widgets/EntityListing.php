<?php

namespace App\Livewire\Widgets;

use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class EntityListing extends Component
{
    use WithPagination;

    #[Locked]
    public Collection $entities;

    #[Locked]
    public CampaignDashboardWidget $widget;

    #[Locked]
    public Campaign $campaign;

    #[Locked]
    public int $pageNumber = 1;

    #[Locked]
    public bool $hasMorePages;

    public function mount(Campaign $campaign, CampaignDashboardWidget $widget)
    {
        $this->entities = new Collection;
        $this->campaign = $campaign;
        $this->widget = $widget;
        $entities = $widget->entities();
        $this->entities->push(...$entities->items());
        $this->hasMorePages = $entities->hasMorePages();
        // $this->loadEntities();
    }

    public function loadEntities()
    {
        $this->pageNumber += 1;
        $entities = $this->widget->entities($this->pageNumber);

        $this->hasMorePages = $entities->hasMorePages();

        $this->entities->push(...$entities->items());
    }

    public function render()
    {
        return view('livewire.dashboards.entity-listing');
    }
}
