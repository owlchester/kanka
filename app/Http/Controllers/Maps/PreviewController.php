<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class PreviewController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;


    public function index(Campaign $campaign, Map $map)
    {
        if (!$campaign->enabled('maps')) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#maps']) . '">' . __('crud.fix-this-issue') . '</a>'
                ])
            );
        }

        $this->campaign($campaign)->authEntityView($map->entity);

        return view('maps.preview')
            ->with('campaign', $campaign)
            ->with('entity', $map->entity)
        ;
    }
}
