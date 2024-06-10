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
        if (!empty($mapMarker->entity_id)) {
            $this->authEntityView($mapMarker->entity);
        }
        /*if (auth()->check()) {
            $this->authorize('view', $map);
            if ($mapMarker->entity_id) {
                // No access to the child? 404
                if (empty($mapMarker->entity->child)) {
                    abort(404);
                }
                $this->authorize('view', $mapMarker->entity->child);
            }
        } else {
            $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $map);
            dd($map);
            if ($mapMarker->entity_id) {
                $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $mapMarker->entity->child, $mapMarker->entity->typeId());
            }
        }*/

        $name = $mapMarker->name;
        if ($mapMarker->entity) {
            $name = !empty($mapMarker->name) ? $mapMarker->name : $mapMarker->entity->name;
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
            'name' => $name
        ]);
    }
}
