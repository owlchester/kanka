<?php

namespace App\Http\Controllers\Maps\Markers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        if (auth()->check()) {
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
            if ($mapMarker->entity_id) {
                $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $mapMarker->entity->child, $mapMarker->entity->typeId());
            }
        }

        $name = $mapMarker->name;
        if ($mapMarker->entity) {
            $name = '<a href="' . $mapMarker->entity->url() . '" target="_blank">';
            if (!empty($mapMarker->name)) {
                $name .= $mapMarker->name;
            } else {
                $name .= $mapMarker->entity->name;
            }
            $name .= '</a>';
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
