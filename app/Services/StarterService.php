<?php

namespace App\Services;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Character;
use App\Models\Entity;
use App\Models\Location;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class StarterService
{
    use UserAware;
    use CampaignAware;


    /**
     * @return Campaign
     */
    public function createCampaign(): Campaign
    {
        $data = [
            'name' => __('starter.campaign.name', ['user' => $this->user->name]),
            'entry' => '',
            'excerpt' => '',
            'ui_settings' => ['nested' => true]
        ];
        /** @var Campaign $campaign */
        $this->campaign = Campaign::create($data);

        try {
            $this->generateBoilerplate();
        } catch (\Exception $e) {
            throw $e;
            // Don't block the user if the boilerplate crashes
        }

        return $this->campaign;
    }

    /**
     * @param Campaign $campaign
     */
    public function generateBoilerplate()
    {
        // For some reason, we need this for the node to be properly created (child location)
        // Todo: avoid this whole loop by making it a request the user is redirected to?
        CampaignLocalization::forceCampaign($this->campaign);

        // Generate locations
        $kingdom = new Location([
            'name' => __('starter.kingdom1.name'),
            'slug' => Str::slug(__('starter.kingdom1.name')),
            'type' => __('starter.kingdom1.type'),
            'entry' => '<p>' . __('starter.kingdom1.description') . '</p>',
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $kingdom->save();

        $city = new Location([
            'name' => __('starter.kingdom2.name'),
            'slug' => Str::slug(__('starter.kingdom2.name')),
            'type' => __('starter.kingdom2.type'),
            'parent_location_id' => $kingdom->id,
            'entry' => '<p>' . __('starter.kingdom2.description') . '</p>',
            'campaign_id' => $this->campaign->id,
            'is_private' => false,
        ]);
        $city->save();

        // Generate characters
        $james = new Character([
            'name' => __('starter.character1.name'),
            'slug' => Str::slug(__('starter.character1.name')),
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
            'name' => __('starter.character2.name'),
            'slug' => Str::slug(__('starter.character2.name')),
            'title' => __('starter.character2.title'),
            'age' => '31',
            'sex' => __('starter.character2.sex'),
            'entry' => '<p>' . __('starter.character2.history') . '</p>',
            'location_id' => $city->id,
            'campaign_id' => $this->campaign->id,
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
            'widget' => CampaignDashboardWidget::WIDGET_WELCOME,
            'width' => 6, // half
            'position' => 1,
        ]);
        $widget->save();

        // Recent widget
        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'widget' => CampaignDashboardWidget::WIDGET_RECENT,
            'width' => 0,
            'position' => 2,
        ]);
        $widget->save();
    }
}
