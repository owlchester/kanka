<?php

namespace App\Livewire\Entities;

use App\Models\Campaign;
use App\Traits\Livewire\CampaignAware;
use Livewire\Component;

class EntityCard extends Component
{
    use CampaignAware;

    public \App\Models\Entity $entity;
    public Campaign $campaign;
    public bool $isParent = false;

    protected $listeners = ['refreshEntityCard' => '$refresh'];

    public function mount(\App\Models\Entity $entity, Campaign $campaign, bool $isParent = false): void
    {
        $this->entity = $entity;
        $this->campaign = $campaign;
        $this->isParent = $isParent;
    }

    public function open()
    {
//        dd($this->entity);
        //$this->dispatch('selected', $this->entity)->to(Explore::class);
    }

    public function render()
    {
        $this->setCampaign();
        return view('livewire.entities.entity-card');
    }
}
