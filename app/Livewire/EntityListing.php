<?php

namespace App\Livewire;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class EntityListing extends Component
{
    use WithPagination;

    public Collection $entities;

    public CampaignDashboardWidget $widget;

    public Campaign $campaign;

    public int $pageNumber = 1;

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
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

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
