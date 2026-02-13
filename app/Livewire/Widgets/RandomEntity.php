<?php

namespace App\Livewire\Widgets;

use App\Facades\Avatar;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Entity;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RandomEntity extends Component
{
    #[Locked]
    public CampaignDashboardWidget $widget;

    #[Locked]
    public Entity $entity;

    #[Locked]
    public Campaign $campaign;

    #[Locked]
    public ?string $customName;

    #[Locked]
    public string $specificPreview;

    #[Locked]
    public bool $readyToLoad = false;

    public function mount(CampaignDashboardWidget $widget, Campaign $campaign)
    {
        $this->widget = $widget;
        $this->campaign = $campaign;
    }

    public function loadEntity(): void
    {
        $this->readyToLoad = true;

        // We need this here for the "load more entities" button that loads more data
        request()->route()->setParameter('campaign', $this->campaign);
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
        if ($entity->isMap()) {
            $this->specificPreview = 'dashboard.widgets.previews.random-map';
        }

        $this->customName = ! empty($this->widget->conf('text')) ? str_replace('{name}', $this->entity->name, $this->widget->conf('text')) : null;
    }

    public function render()
    {
        // We need this here for when the widget gets re-rendered
        request()->route()?->setParameter('campaign', $this->campaign);
        UserCache::campaign($this->campaign);
        Avatar::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        return view('livewire.widgets.random-entity');
    }
}
