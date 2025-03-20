<?php

namespace App\Http\Controllers\Maps\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;

class LayerController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    public function index(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        $this->campaign = $campaign;
        $action = $request->get('action');
        $models = $request->get('model');
        if (! in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->campaign($campaign)->bulkBatch(route('maps.layers.bulk', [$campaign, 'map' => $map]), '_map-layer', $models);
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $count = $this->bulkProcess($request, MapLayer::class);

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->with('success', trans_choice('maps/layers.bulks.' . $action, $count, ['count' => $count]));
    }
}
