<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignDashboardWidget;
use App\Models\Character;
use App\Models\Item;
use App\Models\Location;
use App\Models\Note;

class StarterService
{
    /**
     * @var Campaign
     */
    protected $campaign;

    /**
     * @param Campaign $campaign
     */
    public function generateBoilerplate(Campaign $campaign)
    {
        $this->campaign = $campaign;

        // Generate locations
        $kingdom = new Location([
            'name' => __('starter.kingdom1.name'),
            'type' => __('starter.kingdom1.type'),
            'entry' => '<p>' . __('starter.kingdom1.description') . '</p>',
            'campaign_id' => $campaign->id,
            'is_private' => false,
        ]);
        $kingdom->save();

        $city = new Location([
            'name' => __('starter.kingdom2.name'),
            'type' => __('starter.kingdom2.type'),
            'parent_location_id' => $kingdom->id,
            'entry' => '<p>' . __('starter.kingdom2.description') . '</p>',
            'campaign_id' => $campaign->id,
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
            'campaign_id' => $campaign->id,
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
            'campaign_id' => $campaign->id,
            'fears' => __('starter.character2.fears'),
            'traits' => __('starter.character2.traits'),
            'is_private' => false,
        ]);
        $irwie->save();

        // One item for good measure
        $item = new Item([
            'name' => __('starter.item1.name'),
            'campaign_id' => $campaign->id,
            'type' => __('starter.item1.type'),
            'entry' => '<p>' . __('starter.item1.description') . '</p>',
            'character_id' => $irwie->id,
            'location_id' => $kingdom->id,
            'is_private' => false,
        ]);
        $item->save();


        $this->dashboard();
    }

    /**
     * Setup the new campaign's dashboard
     */
    protected function dashboard()
    {
        // Note for the dashboard
        $entry = nl2br(__('starter.note1.entry', [
            'youtube' => link_to('https://www.youtube.com/channel/UCwb3pl0LOlxd3GvMPAXIEog/videos', 'Youtube'),
            'faq' => link_to_route('faq.index', __('front.faq.title')),
            'discord' => link_to(config('social.discord'), 'Discord'),
            'public' => link_to_route('front.public_campaigns', __('front.menu.campaigns')),
            'subscriptions' => link_to_route('settings.subscription', __('starter.note1.subscriptions')),
        ]));
        $note = new Note([ 'name' => __('starter.note1.name'),
            'campaign_id' => $this->campaign->id,
            'entry' => $entry,
            'is_private' => false,
        ]);
        $note->save();

        $widget = new CampaignDashboardWidget([
            'campaign_id' => $this->campaign->id,
            'entity_id' => $note->entity->id,
            'widget' => CampaignDashboardWidget::WIDGET_PREVIEW,
            'width' => 6, // half
            'config' => '{"full":"1"}',
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
