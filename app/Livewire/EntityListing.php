<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Campaign;
use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Facades\Avatar;
use App\Facades\CampaignCache;

class EntityListing extends Component
{
    use WithPagination;

    public $entities;

    public Campaign $campaign;

    public $pageNumber = 1;

    public $hasMorePages;

    public function mount(Campaign $campaign)
    {

        $this->entities = new Collection();
        $this->campaign = $campaign;

        $this->loadEntities();
    }

    public function loadEntities()
    {
        CampaignLocalization::forceCampaign($this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        $campaign = $this->campaign;

        $this->authorize('access', $campaign);
        $entities = $campaign->entities()
            ->lastSync(request()->get('lastSync'))
            ->paginate(12, ['*'], 'page', $this->pageNumber);

        $this->pageNumber += 1;

        $this->hasMorePages = $entities->hasMorePages();

        $this->entities->push(...$entities->items());
    }

    public function render()
    {
        return view('livewire.entity-listing');
    }
}
