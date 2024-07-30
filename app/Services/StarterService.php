<?php

namespace App\Services;

use App\Enums\Widget;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Character;
use App\Models\Location;
use App\Observers\CharacterObserver;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class StarterService
{
    use CampaignAware;
    use UserAware;

    /**
     * Create a new campaign for the user when they register their account
     */
    public function create(): Campaign
    {
        $data = [
            'name' => __('starter.campaign.name', ['user' => $this->user->name]),
            'entry' => '',
            'excerpt' => '',
        ];
        $this->campaign = Campaign::create($data);
        CampaignCache::campaign($this->campaign);
        UserCache::campaign($this->campaign);

        $this->populate();

        return $this->campaign;
    }

    public function bind(): self
    {
        Character::observe(CharacterObserver::class);
        return $this;
    }

    public function populate()
    {
        CampaignLocalization::forceCampaign($this->campaign);
        EntityCache::campaign($this->campaign);
        CharacterCache::campaign($this->campaign);

        // Generate locations
        $kingdom = new Location([
            'name' => __('starter.kingdom1.name'),
            'type' => __('starter.kingdom1.type'),
            'entry' => '<p>' . __('starter.kingdom1.description') . '</p>',
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $kingdom->save();

        $city = new Location([
            'name' => __('starter.kingdom2.name'),
            'type' => __('starter.kingdom2.type'),
            'location_id' => $kingdom->id,
            'entry' => '<p>' . __('starter.kingdom2.description') . '</p>',
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $city->save();

        // Generate characters
        $james = new Character([
            'name' => __('starter.character1.name'),
            'title' => __('starter.character1.title'),
            'age' => '43',
            'sex' => __('starter.character1.sex'),
            'entry' => '<p>' . __('starter.character1.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $this->campaign->id,
            'fears' => __('starter.character1.fears'),
            'traits' => __('starter.character1.traits'),
            'is_private' => false,
        ]);
        $james->save();

        $irwie = new Character([
            'name' => __('starter.character2.name'),
            'title' => __('starter.character2.title'),
            'age' => '31',
            'sex' => __('starter.character2.sex'),
            'entry' => '<p>' . __('starter.character2.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $this->campaign->id,
            'fears' => __('starter.character2.fears'),
            'traits' => __('starter.character2.traits'),
            'is_private' => false,
        ]);
        $irwie->save();

        $this->dashboard();
    }

    /**
     * Setup the new campaign's dashboard
     */
    protected function dashboard()
    {
        // Note for the dashboard
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Welcome->value,
            'width' => 6, // half
            'position' => 1,
        ]);
        $widget->save();

        // Recent widget
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Recent->value,
            'width' => 0,
            'position' => 2,
        ]);
        $widget->save();
    }
}
