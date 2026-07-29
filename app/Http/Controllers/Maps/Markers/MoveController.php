<?php

namespace App\Http\Controllers\Maps\Markers;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    public function index(Request $request, Campaign $campaign, Map $map, MapMarker $mapMarker)
    {
        $this->authorize('update', $map->entity);
        if (!$mapMarker->is_draggable || $mapMarker->map_id != $map->id) {
            abort(403, 'Marker is not draggable or does not belong to this map.');
        }

        $mapMarker->update($request->only('latitude', 'longitude'));

        return response()->json([
            'success' => true,
            'marker_id' => $mapMarker->id,
        ]);
    }
}
