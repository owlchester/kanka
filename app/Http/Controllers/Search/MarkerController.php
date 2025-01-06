<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\MapMarker;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarkerController extends Controller
{
    public function index(Request $request, Campaign $campaign)
    {
        $term = mb_trim($request->q ?? '');
        //parent map_id allowed for the marker (limits search to the markers of the map only)
        $include = $request->has('include') ? [$request->get('include')] : [];

        //marker must be in given map
        $modelClass = MapMarker::whereIn('map_id', $include);

        //Search text
        if (!empty($term)) {
            if (Str::startsWith($term, '=')) {
                $modelClass->where('name', mb_ltrim($term, '='));
            } else {
                $modelClass->where('name', 'like', "%{$term}%");
            }
        } else {
            $modelClass->orderBy('updated_at', 'desc');
        }

        //execute query
        $models = $modelClass->limit(10)
            ->get();

        //format results for frontend select
        $formatted = [];
        /** @var MapMarker $model */
        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->markerTitle()
            ];

            $formatted[] = $format;
        }

        return response()->json($formatted);
    }
}
