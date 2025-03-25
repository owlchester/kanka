<?php

namespace App\Http\Controllers\Maps\Markers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class DetailController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->campaign($campaign)->authEntityView($map->entity);
        if (! empty($mapMarker->entity_id)) {
            $this->campaign($campaign)->authEntityView($mapMarker->entity);
        }

        $name = $mapMarker->name;
        if ($mapMarker->entity) {
            $name = ! empty($mapMarker->name) ? $mapMarker->name : $mapMarker->entity->name;
            $name = '<a href="' . $mapMarker->entity->url() . '" target="_blank">' . $name . '</a>';
        }
        if (request()->has('mobile')) {
            return response()->view('maps.markers.dialog_details', [
                'marker' => $mapMarker,
                'campaign' => $campaign,
                'name' => $name,
            ]);
        }

        return response()->json([
            'body' => view('maps.markers.details', [
                'marker' => $mapMarker,
                'campaign' => $campaign,
            ])->render(),
            'name' => $name,
        ]);
    }
}
