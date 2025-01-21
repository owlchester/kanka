<?php

namespace App\Http\Controllers\Maps\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    public function index(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);
        $action = $request->get('action');
        $models = $request->get('model');
        if (!in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->campaign($campaign)->bulkBatch(route('maps.markers.bulk', [
                'campaign' => $campaign, 'map' => $map]), '_map-marker', $models, $map);
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $count = $this->campaign($campaign)->bulkProcess($request, MapMarker::class);

        return redirect()
            ->route('maps.map_markers.index', [$campaign, 'map' => $map])
            ->with('success', trans_choice('maps/markers.bulks.' . $action, $count, ['count' => $count]))
        ;
    }
}
