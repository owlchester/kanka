<?php

namespace App\Livewire\Entities;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\Connections\RelatedService;
use Livewire\Component;
use Livewire\WithPagination;

class Related extends Component
{
    use WithPagination;

    public Campaign $campaign;

    public Entity $entity;

    public int $count;

    public string $sortColumn = 'name'; // Default column to sort by

    public string $sortDirection = 'desc'; // Default sort direction (asc/desc)

    protected RelatedService $connectionService;


    public function mount(Campaign $campaign)
    {
        $this->campaign = $campaign;
        
        CampaignLocalization::forceCampaign($this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        $this->connectionService = app()->make(RelatedService::class);
        
    }

    public function sortBy($column)
    {
        // Toggle sorting direction if the same column is clicked
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function sortIcon(): string
    {

        $icon = 'fa-solid fa-arrow-down-z-a';

        if ($this->sortDirection == 'asc') {
            $icon = 'fa-solid fa-arrow-up-a-z';
        }

        return '<i class="' . $icon . ' !mr-0"></i>';
    }

    public function render()
    {
        //Copy pasted here
        CampaignLocalization::forceCampaign($this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        $this->connectionService = app()->make(RelatedService::class);

        $connections = $this->connectionService
            ->entity($this->entity)
            ->order($this->sortColumn, $this->sortDirection)
            ->connections();

        return view('livewire.entities.related', ['connections' => $connections]);
    }
}
