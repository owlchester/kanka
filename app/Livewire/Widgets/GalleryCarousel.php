<?php

namespace App\Livewire\Widgets;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Image;
use Livewire\Attributes\Locked;
use Livewire\Component;

class GalleryCarousel extends Component
{
    #[Locked]
    public CampaignDashboardWidget $widget;

    #[Locked]
    public Campaign $campaign;

    #[Locked]
    public array $images = [];

    #[Locked]
    public bool $readyToLoad = false;

    #[Locked]
    public bool $showName = false;

    public function mount(CampaignDashboardWidget $widget, Campaign $campaign): void
    {
        $this->widget = $widget;
        $this->campaign = $campaign;
        $this->showName = $this->widget->conf('show_name') == '1';
    }

    public function loadImages(): void
    {
        $this->readyToLoad = true;

        request()->route()->setParameter('campaign', $this->campaign);
        UserCache::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        $folderId = $this->widget->conf('folder_id');
        if (empty($folderId)) {
            return;
        }

        $images = Image::where('campaign_id', $this->campaign->id)
            ->where('folder_id', $folderId)
            ->where('is_folder', false)
            ->acl(true)
            ->orderBy('name', 'asc')
            ->limit(30)
            ->get();

        $this->images = $images
            ->filter(fn (Image $image) => $image->hasThumbnail())
            ->map(fn (Image $image) => [
                'url' => $image->getUrl(800, 600),
                'full' => $image->getUrl(),
                'name' => $image->name,
            ])
            ->values()
            ->toArray();
    }

    public function render()
    {
        request()->route()?->setParameter('campaign', $this->campaign);
        UserCache::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);

        return view('livewire.widgets.gallery-carousel');
    }
}
