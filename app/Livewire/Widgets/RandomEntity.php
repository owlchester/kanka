<?php

namespace App\Livewire\Widgets;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Entity;
use Livewire\Component;

class RandomEntity extends Component
{
    public CampaignDashboardWidget $widget;

    public Entity $entity;

    public Campaign $campaign;

    public ?string $customName;

    public string $specificPreview;

    public bool $readyToLoad = false;

    public function mount(CampaignDashboardWidget $widget, Campaign $campaign)
    {
        $this->widget = $widget;
        $this->campaign = $campaign;
    }

    public function loadEntity(): void
    {
        $this->readyToLoad = true;

        CampaignLocalization::forceCampaign($this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        $entity = $this->widget->randomEntity();
        if (! $entity) {
            return;
        }
        $this->entity = $entity;
        \App\Facades\Dashboard::add($this->entity);
        $this->widget->setEntity($this->entity);

        $this->specificPreview = 'dashboard.widgets.previews.' . $this->entity->entityType->code;
        $this->customName = ! empty($this->widget->conf('text')) ? str_replace('{name}', $this->entity->name, $this->widget->conf('text')) : null;
    }

    public function render()
    {
        return view('livewire.widgets.random-entity');
    }
}
