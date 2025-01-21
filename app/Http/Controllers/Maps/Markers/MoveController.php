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

        $mapMarker->update($request->only('latitude', 'longitude'));

        return response()->json([
            'success' => true,
            'marker_id' => $mapMarker->id
        ]);
    }
}
