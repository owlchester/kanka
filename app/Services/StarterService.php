<?php

namespace App\Services;

use App\Enums\Widget;
use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\CharacterCache;
use App\Facades\EntityCache;
use App\Facades\EntityPermission;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Character;
use App\Models\Location;
use App\Observers\CharacterObserver;
use App\Services\Campaign\CreateService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class StarterService
{
    use CampaignAware;
    use UserAware;

    public function __construct(protected CreateService $createService) {}

    /**
     * Create a new campaign for the user when they register their account
     */
    public function create(): Campaign
    {
        $name = __('starter.campaign.name', ['user' => $this->user->name]);
        $request = [
            'name' => $name,
            'entry' => '',
            'excerpt' => '',
            'settings' => ['default-name' => $name],
        ];

        $this->campaign = $this->createService
            ->user($this->user)
            ->data($request)
            ->create();

        EntityPermission::campaign($this->campaign);
        CampaignCache::campaign($this->campaign);
        UserCache::campaign($this->campaign);

        $this->entities();
        $this->dashboard();

        session()->put('onboarding', 1);

        return $this->campaign;
    }

    public function bind(): self
    {
        Character::observe(CharacterObserver::class);

        return $this;
    }

    public function entities()
    {
        CampaignLocalization::forceCampaign($this->campaign);
        request()->route()->setParameter('campaign', $this->campaign);
        EntityCache::campaign($this->campaign);
        CharacterCache::campaign($this->campaign);

        // Generate locations
        $kingdom = new Location([
            'name' => __('starter.name', ['name' => 'Genory']),
            'type' => __('starter.kingdom1.type'),
            'entry' => '<p>' . __('starter.kingdom1.description') . '</p>',
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $kingdom->save();

        $city = new Location([
            'name' => __('starter.name', ['name' => 'Ulyss']),
            'type' => __('starter.kingdom2.type'),
            'location_id' => $kingdom->id,
            'entry' => '<p>' . __('starter.kingdom2.description') . '</p>',
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $city->save();

        // Generate characters
        $james = new Character([
            'name' => __('starter.name', ['name' => 'James Owlchester']),
            'title' => __('starter.character1.title'),
            'age' => '43',
            'sex' => __('starter.character1.sex'),
            'entry' => '<p>' . __('starter.character1.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $james->save();

        $irwie = new Character([
            'name' => __('starter.name', ['name' => 'Irwie Gemstone']),
            'title' => __('starter.character2.title'),
            'age' => '31',
            'sex' => __('starter.character2.sex'),
            'entry' => '<p>' . __('starter.character2.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $irwie->save();
    }

    /**
     * Setup the new campaign's dashboard
     */
    protected function dashboard()
    {
        $position = 0;

        // Recent widget
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Recent,
            'width' => 4,
            'position' => $position++,
        ]);
        $widget->save();

        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Onboarding,
            'width' => 4,
            'position' => $position++,
        ]);
        $widget->save();

        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => Widget::Help,
            'width' => 4,
            'position' => $position++,
        ]);
        $widget->save();
    }
}
