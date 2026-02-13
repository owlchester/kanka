<?php

namespace App\Livewire;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
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
        // We need this here for the "load more entities" button that loads more data
        request()->route()->setParameter('campaign', $this->campaign);
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
        // We need this here for when the widget gets re-rendered
        request()->route()?->setParameter('campaign', $this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        return view('livewire.dashboards.entity-listing');
    }
}
